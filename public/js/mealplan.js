$(document).ready(function(){
    $('#remove_food').click(function(){
        $('#food_selectpicker').selectpicker('deselectAll');
    });
    $('#remove_recipes').click(function(){
        $('#recipes_selectpicker').selectpicker('deselectAll');
    });
    $('.yes').click(function(){
        var html;
        var meals = [];
        $.each($(".selectpicker option:selected"), function() {
            meals.push($(this).val());
        });
       meals.forEach(function(meal) {
            //html += '<li class="list-group-item">' + meal + '</li>';
            $('.list-group').append('<li class="list-group-item">' + meal + 
                '<a><span title="Delete from grocerylist" class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span></a></li>' );
       });
       //$('.list-group').append(html);
       $('#food_selectpicker').selectpicker('deselectAll');
       $('#recipes_selectpicker').selectpicker('deselectAll');
    });

    $('.glyphicon-remove').click(function(){
        alert("HI");
        var item = $(this).parent('.list-group-item');
        item.remove();

    });

    //var calendar = $('#calendar').fullCalendar('getCalendar');

    // $('#calendar').fullCalendar({
    //     defaultView: 'basicWeek',
    //     height: 650,
    //     firstDay: 1,
    //     titleFormat: 'DD. MMM YYYY',
    //     columnHeaderFormat: 'ddd DD.MMM',
    //     // dayClick: function() {
    //     //     alert('a day has been clicked!');
    //     // }
    //     dayClick: function(date, jsEvent, view) {
    //         alert('Clicked on: ' + date.format());
    //         alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    //         alert('Current view: ' + view.name);
    //     // change the day's background color just for fun
    //     //$(this).css('background-color', 'red');
    //     }
    // });

    var calendar = $('#calendar').fullCalendar({
        defaultView: 'basicWeek',
        //slotLabelFormat: '"Breakfast"',
        slotLabelInterval: {hours:6},
        slotDuration: '06:00:00',
        titleFormat: 'DD. MMMM YYYY',
        displayEventTime: false,
        columnHeaderFormat: 'ddd DD.MMM',
        height: 650,
        firstDay: 1,
        editable:true,
        header:{
            left:'',
            center:'title'
        },
        //events: '',
        // selectable:true,
        // selectHelper:true,
    
    });
    var targetDiv = document.getElementById("2018-03-12").getElementsByClassName("breakfast-section")[0];
    targetDiv.innerHTML = "<li class='list-group-item text-center'>Eier <a href='#'>" + 
    "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a></li>";

});