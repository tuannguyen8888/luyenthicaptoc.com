<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use CRUDBooster;
use CB;
use Schema;
use Illuminate\Support\Facades\DB;
//use Webklex\IMAP\Client;
use Illuminate\Support\Facades\Log;

use Webklex\PHPIMAP\Message;
use Webklex\PHPIMAP\Folder;
use Webklex\IMAP\Facades\Client as ClientFacade;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class CheckMomoTransferEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckMomoTransferEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra email chuyển khoản Momo để xác nhận nộp tiền';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->getTimestamp();
        Log::debug(CRUDBooster::getCurrentMethod() . date('Y-m-d H:i:s') . ' Kiểm tra email chuyển khoản để xác nhận nộp tiền');
        $channels = DB::table('payment_channel')->whereNull('deleted_at')->where('status', 'ACTIVE')->get();
        if($channels && count($channels)){
            foreach ($channels as $channel){
                Log::debug('Channel '.$channel->name);
                $last_time = Redis::get('CheckTransferEmail_last_time_'.$channel->id);
                if(!$last_time){
                    $last_time = Carbon::createFromDate(2020,01,01)->getTimestamp();
                }
                Log::debug('CheckTransferEmail_last_time_'.$channel->id.' = '.Carbon::createFromTimestamp($last_time)->toDateTimeString());
                try {
                    $oClient = ClientFacade::account($this->account);
                    $oClient->connect();
                    $oFolder = $oClient->getFolder("INBOX");
                    $query = $oFolder
                        ->search('UTF-8')
                        ->from($channel->notification_email)
                        ->since(Carbon::createFromTimestamp($last_time))
//                  ->subject('Bạn vừa nhận được tiền')
                        ->body($channel->keyword)
                        ->setFetchOrderAsc();
                    if ($query->count() > 0) {
                        $messages = $query->get();
                        foreach ($messages as $mess) {
                            if (strpos($mess->getSubject(), $channel->key_string_subject)) {
                                $body = $mess->getHTMLBody();
                                $start_pos = strpos($body, $channel->start_string) + strlen($channel->start_string);
                                $body_sub = preg_replace('!\s+!', ' ', substr($body, $start_pos));
                                $body_content = strip_tags($body_sub);
                                Log::debug('--------------');
                                Log::debug('Subject = ' . $mess->getSubject());
                                Log::debug('$body_content = ' . $body_content);
//                                $pattern = '/Số\stiền\s+([\d*.\d{3}]*)\s*Người\sgửi\s+(\D*)\s*Số\sđiện\sthoại\sngười\sgửi\s+(\d+)\s*Thời\sgian\s+(.+\d)\s*(Lời\snhắn|Lời\schúc)\s+(.*)\s*Mã\sgiao\sdịch\s+(\d+)/';
                                preg_match($channel->regex_pattern, $body_content, $group);
                                Log::debug('preg_match group = ', $group);
                                if (count($group)) { //if (count($group) >= 7) {
                                    $amount = doubleval(str_replace('.', '', $group[$channel->index_amount]));
                                    $sender_name = trim($group[$channel->index_sender_name]);
                                    $sender_phone = trim($group[$channel->index_sender_phone]);
                                    $time = trim($group[$channel->index_time]);
//                            $content = mb_convert_encoding(trim(strtoupper($group[6])), 'UTF-8', 'Windows-1252');
                                    $content = trim(strtoupper($group[$channel->index_content]));
                                    $payment_code = trim($group[$channel->index_payment_code]);

                                    Log::debug('$amount = ' . $amount);
                                    Log::debug('$sender_name = ' . $sender_name);
                                    Log::debug('$sender_phone = ' . $sender_phone);
                                    Log::debug('$time = ' . $time);
                                    Log::debug('$content = ' . $content);
                                    Log::debug('$payment_code = ' . $payment_code);

                                    $tran = DB::table('transaction as T')
                                        ->whereNull('T.deleted_at')
                                        ->where('T.trans_type', 'CASHIN')
                                        ->where('T.status', 'WAITING_CONFIRM')
                                        ->where('T.trans_code', $content)
                                        ->first();
                                    if (!$tran) {
                                        $tran = DB::table('transaction as T')
                                            ->leftJoin('cms_users as U', 'T.user_id', '=', 'U.id')
                                            ->whereNull('T.deleted_at')
                                            ->whereNull('U.deleted_at')
                                            ->where('T.status', 'WAITING_CONFIRM')
                                            ->where('T.trans_type', 'CASHIN')
                                            ->where('U.phone', $sender_phone)
                                            ->first();
                                    }
                                    if ($tran) {
                                        DB::table('transaction_cashin_confirm')
                                            ->insert([
                                                'transaction_id' => $tran->id,
                                                'payment_channel_id' => $channel->id,
                                                'date_time' => Carbon::createFromFormat('d/m/Y - H:i',$time)->format('Y-m-d H:i:s'),
                                                'sender_name' => $sender_name,
                                                'sender_phone' => $sender_phone,
                                                'amount' => $amount,
                                                'content' => $content,
                                                'payment_code' => $payment_code,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'created_by' => 2
                                            ]);
                                        DB::table('transaction')
                                            ->where('id', $tran->id)
                                            ->update([
                                                'status' => 'CONFIRMED',
                                                'updated_at' => date('Y-m-d H:i:s'),
                                                'updated_by' => 2
                                            ]);
                                        DB::table('cms_users')
                                            ->where('id', $tran->user_id)
                                            ->increment('blance', $amount);
                                        $user = DB::table('cms_users')->where('id', $tran->user_id)->first();
                                        $noti = "Hệ thống đã xác nhận lệnh nạp tiền ".number_format($amount,0,'.',',')." đ mã nạp $tran->trans_code của user $user->name ($user->phone) qua kênh $channel->name (Người gởi: $sender_name $sender_phone, mã giao dịch $channel->name: $payment_code, thời gian gởi: $time)";
                                        send_message_to_group_telegram($noti);
                                        Log::debug($noti);
                                    }else{
                                        $noti = "Hệ thống nhận được ".number_format($amount,0,'.',',')." đ từ $sender_name".(($sender_phone && $sender_phone)?' - ':'')."$sender_phone lúc $time nhưng không thể xác nhận do không tìm được lệnh gốc, admin vui lòng kiểm tra lại với người gởi. Mã giao dịch $channel->name: $payment_code";
                                        send_message_to_group_telegram($noti);
                                        Log::debug($noti);
                                    }
                                }
                                Log::debug('==============');
                            }
                        }
                    }
                    Redis::set('CheckTransferEmail_last_time_'.$channel->id, $now);
//            }
                } catch (Exception $exception) {
                    Log::error(CRUDBooster::getCurrentMethod() . date('Y-m-d H:i:s') . $exception->getMessage() . '\n line = ' . $exception->getLine() . '\n ' . $exception->getTraceAsString());
                }
            }
        }
        //

    }
}
