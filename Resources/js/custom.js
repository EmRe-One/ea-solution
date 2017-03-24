/**
 * Created by Emre Ak on 24.03.2017.
 */

(function () {
    var search_form_opened = false;

    $('.button-collapse').sideNav({
            menuWidth: 300, // Default is 300
            edge: 'left', // Choose the horizontal origin
            closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
            draggable: true // Choose whether you can drag to open on touch screens
        }
    );

    $('.parallax').parallax();

    $('.nav-search > a').on('click', function () {
        search_form_open(true);
    });

    $('.material-search-close').on('click', function () {
        search_form_open(false);
    });

    function search_form_open(bool) {
        search_form_opened = bool;
        if (bool) {
            $('.material-search-overlay').removeClass('material-search-overlay-hidden')
                .addClass('material-search-overlay-visible');
            $('.material-search-form').removeClass('material-search-form-hidden')
                .addClass('material-search-form-visible');
            setTimeout(function () {
                $('.material-search-input > input').focus();
            },500);
        } else {
            $('.material-search-overlay').removeClass('material-search-overlay-visible')
                .addClass('material-search-overlay-hidden');
            $('.material-search-form').removeClass('material-search-form-visible')
                .addClass('material-search-form-hidden');
        }
    }

    $(window).scroll(function () {
        var currentPosition = $(window).scrollTop();

        if(currentPosition < 200){
            $('.fixed-action-btn').fadeOut(500);
        }else{
            $('.fixed-action-btn').fadeIn(500);
        }

        if (search_form_opened) {
            search_form_open(false);
        }
    }); // end of scroll

})();