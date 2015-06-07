$(document).ready(function () {
    // initialize input widgets first
    $(' .time').focus(function () {
        $(this).timepicker({
            'showDuration': true,
            'timeFormat': 'H:i:s' 
        });
    });
});