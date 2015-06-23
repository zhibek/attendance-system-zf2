$(document).ready(function () {
    
    
     $('#attachment-label').attr("class","attach_hide");
    
    
    
    
    
    // onToDateChangEvent
    $('#toDate').datepicker().on('changeDate', function () {
        /**
         * myDateParser
         * @param {date} date object
         * @return {array} array of date elements [month][day][year]
         * */
        function myDateParser(date)
        {
            var dateArray = date.split('/')
            return new Date(dateArray[2], dateArray[0] - 1, dateArray[1]);
        }

        /**
         * myDateSubstractor
         * @param {string} fromDate, {string} toDate
         * @return {int} the different between the two argument dates
         * */
        function myDateSubstractor(fromDate, toDate) {
            return (toDate - fromDate) / (1000 * 60 * 60 * 24);
        }


        var nomOfVacationDays = myDateSubstractor(myDateParser($('#fromDate').val()), myDateParser($('#toDate').val()));
        
        if (nomOfVacationDays == 0)
        {
            $('#type').empty();
            $('#type').append($('<option>', {
                value: '2',
                text: 'Casual'
            }));
            $('#type').append($('<option>', {
                value: '3',
                text: 'Annual'
            }));
            $('#type').append($('<option>', {
                value: '1',
                text: 'Sick'
            }));

        }
        else
        {
            $('#type').empty();
            $('#type').append($('<option>', {
                value: '3',
                text: 'Annual'
            }));
            $('#type').append($('<option>', {
                value: '1',
                text: 'Sick'
            }));
        }


    });

    // onFromDateChange
    $('#fromDate').datepicker().on('changeDate', function () {
         $('#type').empty();
            $('#type').append($('<option>', {
                value: '2',
                text: 'Casual'
            }));
            $('#type').append($('<option>', {
                value: '3',
                text: 'Annual'
            }));
            $('#type').append($('<option>', {
                value: '1',
                text: 'Sick'
            }));
        
    });
    
    // onVacationTypeChange
    $('#type').on('change', function () {
        
        if ($('#type').val() == 1)
        {

            $('#attachment').attr("class", "attach_display");
            $('#attachment-label').attr("class","attach_display");
        }
        else
        {
            $('#attachment').attr("class", "attach_hide");
            $('#attachment-label').attr("class","attach_hide");
        }
    });

});
