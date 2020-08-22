@push('bottom')

<script src="{{ asset ('/assets/js/jquery.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('/assets/js/aes.js') }}"></script>

<script>

    function blockUIForDownload(token) {

	fileDownloadCheckTimer = window.setInterval(function () {
	    var cookieValue = $.cookie('fileDownloadToken');

	    if (cookieValue && cookieValue !== '') {
		console.log("atob cookieValue = " + atob(cookieValue));
		var encrypted_json = atob(cookieValue);
		console.log("encrypted_json = " + encrypted_json);
		var obj = jQuery.parseJSON(encrypted_json);

		var key = "<?php echo env('APP_KEY'); ?>";
		key = key.substr(7);

		var decrypted = CryptoJS.AES.decrypt(obj.value, CryptoJS.enc.Base64.parse(key), {
		    iv: CryptoJS.enc.Base64.parse(obj.iv)
		});

		var get_token = decrypted.toString(CryptoJS.enc.Utf8);
		console.log("get_token = " + get_token);
		var get_token_check = get_token.substr(6, 13);
		console.log("get_token_check = " + get_token_check);

		if (get_token_check === token) {
		    console.log("finishDownload");
		    window.clearInterval(fileDownloadCheckTimer);
		    $.removeCookie('fileDownloadToken');
		    $('.loading').hide();
		}
	    }

	}, 1000);
    }
</script>
@endpush