(function($) {
    "use strict";
    if($('#CountdownNew').data('end-date')) {
        var end_date = $('#CountdownNew').data('end-date');
        var arrDate = end_date.split('-');
        var $y = arrDate[0];
        var $m = arrDate[1];
        var $d = arrDate[2];
        var $g = arrDate[3];
        var $i = arrDate[4].replace(/^0/, '');
        var $s = arrDate[5].replace(/^0/, '');
        simplyCountdown('#CountdownNew', {
            year: $y, // required
            month: $m, // required
            day: $d, // required
            hours: $g, // Default is 0 [0-23] integer
            minutes: $i, // Default is 0 [0-59] integer
            seconds: $s, // Default is 0 [0-59] integer
            words: { //words displayed into the countdown
                days: 'day',
                hours: 'hour',
                minutes: 'minute',
                seconds: 'second',
                pluralLetter: 's'
            },
            plural: true, //use plurals
            inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
            inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
            // in case of inline set to false
            enableUtc: true,
            onEnd: function() {
                // your code
                return;
            },
            refresh: 1000, //default refresh every 1s
            sectionClass: 'simply-section', //section css class
            amountClass: 'simply-amount', // amount css class
            wordClass: 'simply-word' // word css class
        });
    }
})(jQuery);
