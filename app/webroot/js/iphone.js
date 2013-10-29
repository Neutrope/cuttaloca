/**
 * Created by u1aryz on 2013/10/29.
 */
(function() {
    var _this = this;

    $(function() {
        $('.pageTop').click(function() {
            $("html, body").animate({ scrollTop: 0 }, 'normal');
            return false;
        });

        // 縦横切替でulのサイズを調整
        $(window).bind("resize load",function(){
            var h = $('.photoWrapper img.current').height();
            $('.photoWrapper ul.sp').height(h);
        });
    });

}).call(this);