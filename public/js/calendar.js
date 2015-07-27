$(document).ready(function () {

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        editable: true,
        timeFormat: '(:)',
        eventSources:
        [
            {
                url : '/settings/holiday/fetchallholiday'
            }
        ],

        eventMouseover: function(event) { 
            var str  ="<a href = '/settings/holiday/edit/id/__event.id__' class ='glyphicon glyphicon-edit' style ='color : white'></a>";
            var link = str.replace("__event.id__", event.id);
            $(this).append(link);
        },

        eventMouseout: function(event) {
             $( this ).find( "a:last" ).remove();
        },

    });
});