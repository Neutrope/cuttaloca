/**
 * Created by u1aryz on 2013/10/29.
 */
(function() {
    var _this = this;

    $('.pageTop').click(function() {
        $("html, body").animate({ scrollTop: 0 }, 'normal');
        return false;
    });

}).call(this);