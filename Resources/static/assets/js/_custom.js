/**
 * Created by Emre Ak on 24.03.2017.
 */
(function () {
/*
    var s = skrollr.init({
        smoothScrolling: true
    });
*/

    $('.parallax').parallax();

    $( window ).on( 'load', function(){
        setTimeout( function(){
            $('body').addClass('loaded');
        }, 200)
    });
})();