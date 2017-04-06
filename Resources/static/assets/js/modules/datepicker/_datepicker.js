/**
 * Created by Emre Ak on 24.03.2017.
 */

(function () {

    $('.datepicker').pickadate({
        min: true,
        disable: [6, 7],
        autoclose: true,
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 1 // Creates a dropdown of 1 years to control year
    });

    jQuery.extend(jQuery.fn.pickadate.defaults, {
        monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        today: 'Heute',
        clear: 'Löschen',
        close: 'Schließen',
        firstDay: 1,
        format: 'dddd, dd. mmmm yyyy',
        formatSubmit: 'yyyy/mm/dd'
    });
})();