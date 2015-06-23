$(document).ready(function () {
//    $('#calendar').fullCalendar({
//        
//    });
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2015-06-24',
        defaultView: 'month',
        editable: true,
        events: [
            {
                title: 'Graduation Project Event',
                url: 'http://google.com/',
                start: '2015-06-24'
            },
            {
                title: 'Christmas Nights',
                start: '2015-01-01',
                end: '2015-01-07'
            },
            {
                title: '25 Jan Revolution',
                start: '2015-01-25'
            },
            {
                title: 'Mothers Day',
                start: '2015-03-21'
            },
            {
                title: 'Fathers Day',
                start: '2015-06-20'
            },
            {
                title: 'Eid El-Fetr',
                start: '2015-07-18'
            },
            {
                title: '6 October',
                start: '2015-10-06'
            },
            {
                title: 'Eid El-Adha',
                start: '2015-09-19'
            },
            {
                title: 'Muslim New Year',
                start: '2015-10-15'
            },
            {
                title: 'Labor Day',
                start: '2015-05-01'
            },
            {
                title: 'Eid Tahrir Sinai',
                start: '2015-04-25'
            },
            {
                title: 'Revolution Day July 23',
                start: '2015-07-23'
            },
            {
                title: 'Coptic New Year',
                start: '2015-09-12'
            },
            {
                title: "Prophet Mohamed's birthday",
                start: '2015-11-24'
            },
        ]
    });

});