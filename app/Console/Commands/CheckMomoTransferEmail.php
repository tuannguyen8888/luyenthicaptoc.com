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
        Log::debug(CRUDBooster::getCurrentMethod() . date('Y-m-d H:i:s') . ' Kiểm tra email chuyển khoản Momo để xác nhận nộp tiền');
        //
        $last_time = Redis::get('CheckMomoTransferEmail_last_time');
        if(!$last_time){
            $last_time = Carbon::createFromDate(2020,01,01)->getTimestamp();
        }
        Log::debug('CheckMomoTransferEmail_last_time = '.Carbon::createFromTimestamp($last_time)->toDateTimeString());
        $now = Carbon::now()->getTimestamp();
        try {
            $oClient = ClientFacade::account($this->account);
            $oClient->connect();
            $oFolder = $oClient->getFolder("INBOX");
            $query = $oFolder
                ->search('UTF-8')
                ->from('no-reply@momo.vn')
                ->since(Carbon::createFromTimestamp($last_time))
//                  ->subject('Bạn vừa nhận được tiền')
                ->body('MoMo')
                ->setFetchOrderAsc();
            if ($query->count() > 0) {
                $messages = $query->get();
                foreach ($messages as $mess) {
                    if (strpos($mess->getSubject(), 'vừa nhận được tiền từ')) {
                        $body = $mess->getHTMLBody();
                        $start_pos = strpos($body, 'CHI TIẾT GIAO DỊCH') + strlen('CHI TIẾT GIAO DỊCH');
                        $body_sub = preg_replace('!\s+!', ' ', substr($body, $start_pos));
                        $body_content = strip_tags($body_sub);
                        Log::debug('--------------');
                        Log::debug('Subject = ' . $mess->getSubject());
                        Log::debug('$body_content = ' . $body_content);
                        $patterm = '/Số\stiền\s+([\d*.\d{3}]*)\s*Người\sgửi\s+(\D*)\s*Số\sđiện\sthoại\sngười\sgửi\s+(\d+)\s*Thời\sgian\s+(.+\d)\s*(Lời\snhắn|Lời\schúc)\s+(.*)\s*Mã\sgiao\sdịch\s+(\d+)/';
                        preg_match($patterm, $body_content, $group);
                        Log::debug('preg_match group = ', $group);
                        if (count($group) >= 7) {
                            $amount = doubleval(str_replace('.', '', $group[1]));
                            $sender_name = trim($group[2]);
                            $sender_phone = trim($group[3]);
                            $time = trim($group[4]);
//                            $content = mb_convert_encoding(trim(strtoupper($group[6])), 'UTF-8', 'Windows-1252');
                            $content = trim(strtoupper($group[6]));
                            $payment_code = trim($group[7]);

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
                                        'channel' => 'MOMO',
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
                                $noti = "Hệ thống đã xác nhận lệnh nạp tiền ".number_format($amount,0,'.',',')." đ mã nạp $tran->trans_code của user $user->name ($user->phone) qua kênh Momo (Người gởi: $sender_name $sender_phone, mã giao dịch Momo: $payment_code, thời gian gởi: $time)";
                                send_message_to_group_telegram($noti);
                                Log::debug($noti);
                            }else{
                                $noti = "Hệ thống nhận được ".number_format($amount,0,'.',',')." đ từ $sender_name".(($sender_phone && $sender_phone)?' - ':'')."$sender_phone lúc $time nhưng không thể xác nhận do không tìm được lệnh gốc, admin vui lòng kiểm tra lại với người gởi. Mã giao dịch Momo: $payment_code";
                                send_message_to_group_telegram($noti);
                                Log::debug($noti);
                            }
                        }
                        Log::debug('==============');
                    }
                }
            }
            Redis::set('CheckMomoTransferEmail_last_time', $now);
//            }
        } catch (Exception $exception) {
            Log::error(CRUDBooster::getCurrentMethod() . date('Y-m-d H:i:s') . $exception->getMessage() . '\n line = ' . $exception->getLine() . '\n ' . $exception->getTraceAsString());
        }
    }
}
