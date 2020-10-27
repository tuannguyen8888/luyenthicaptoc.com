<script>
    $(document).ready(function(){
        $(".hinhanh").click(function(){
            $(".thpt1").css({"border-radius":"25px","text-align":"center","width":"200px","background-color":"#002147","color": "#fff"});
            $(".kythi").css({"border-radius":"25px","width":"200px","text-align":"center","background-color":"#002147","color": "#fff"});
            $(".thpt3").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
            $(".kt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
            $(".thpt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
            $(".kt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
        });

        $(window).resize(function() {
            resize_imgs_dethi();
        });
        setTimeout(resize_imgs_dethi, 500);
    });

    function resize_imgs_dethi() {
        let imgs = $('.dethi img');
        let width = 0;
        for (let i = 0; i < imgs.length; i++) {
            width = width < $(imgs[i]).width() ? $(imgs[i]).width() : width;
        }
        $('.dethi img').height(width);
        let dethis = $('.dethi');
        let height = 0;
        for (let i = 0; i < dethis.length; i++) {
            height = height < $(dethis[i]).height() ? $(dethis[i]).height() : height;
        }
        $('.dethi').height(height);
    }
</script>