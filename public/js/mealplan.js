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

    var calendar = $('#calendar').fullCalendar({
        defaultView: 'basicWeek',
        slotLabelInterval: {hours:6},
        slotDuration: '06:00:00',
        titleFormat: 'DD. MMMM YYYY',
        displayEventTime: false,
        columnHeaderFormat: 'ddd DD.MMM',
        height: 650,
        firstDay: 1,
        editable:true,
        header:{
            left:'title',
            center:''
        },
        //events: '',
        // selectable:true,
        // selectHelper:true,
    
    });

    $('.addMealplanItemButton').click(function() {
        var target = this.closest('.fc-day-header').getAttribute('data-date');
        $("#MealplanItem_mealplanId").val(target); 
    });

    $('td.fc-day').each(function() {
        var breakfastSection = $(this).find('.breakfast-section');
        var lunchSection = $(this).find('.lunch-section'); 
        var dinnerSection = $(this).find('.dinner-section'); 
        var snacksSection = $(this).find('.snacks-section'); 
        var calendarRow = $(this);
        var targetId = calendarRow.attr('id');
        var itemInList;
        $('#mealplanItemList li').each(function() {
            itemInList = $(this);
            if (this.getAttribute('data-item-mealplan')== targetId) {
                if (this.getAttribute('data-category') == "Breakfast") {
                    if(this.hasAttribute('data-item-name')) {
                        var item = this.getAttribute('data-item-name');
                    }
                    if(this.hasAttribute('data-item-recipe')) {
                        var item = this.getAttribute('data-item-recipe');
                    }
                    var id = this.getAttribute('data-item-id');
                    var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                        "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                        "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                        "</form></li>";
                    breakfastSection.append(content);
                };
                if (this.getAttribute('data-category') == "Lunch") {
                    if(this.hasAttribute('data-item-name')) {
                        var item = this.getAttribute('data-item-name');
                    }
                    if(this.hasAttribute('data-item-recipe')) {
                        var item = this.getAttribute('data-item-recipe');
                    }
                    var id = this.getAttribute('data-item-id');
                    var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                        "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>"+
                        "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                        "</form></li>";
                    lunchSection.append(content);
                };
                if (this.getAttribute('data-category') == "Dinner") {
                    if(this.hasAttribute('data-item-name')) {
                        var item = this.getAttribute('data-item-name');
                    }
                    if(this.hasAttribute('data-item-recipe')) {
                        var item = this.getAttribute('data-item-recipe');
                    }
                    var id = this.getAttribute('data-item-id');
                    var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                        "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                        "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                        "</form></li>";
                    dinnerSection.append(content);
                };
                if (this.getAttribute('data-category') == "Snacks") {
                    if(this.hasAttribute('data-item-name')) {
                        var item = this.getAttribute('data-item-name');
                    }
                    if(this.hasAttribute('data-item-recipe')) {
                        var item = this.getAttribute('data-item-recipe');
                    }
                    var id = this.getAttribute('data-item-id');
                    var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                        "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                        "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                        "</form></li>";
                    snacksSection.append(content);
                };
            };
            return itemInList;
        });

        var element;
        $('.delete-item-button').on('click', function(event) {
            event.preventDefault();
            element = $(this).closest('li');
            element.find('.delete-form').submit();
        });
        $('.delete-form').ajaxForm({
            success: function() {
                element.remove();
                itemInList.remove();
            }
        });
    });

    $('.fc-button').on('click', function() {
        $('td.fc-day').each(function() {
            var breakfastSection = $(this).find('.breakfast-section');
            var lunchSection = $(this).find('.lunch-section'); 
            var dinnerSection = $(this).find('.dinner-section'); 
            var snacksSection = $(this).find('.snacks-section'); 
            var calendarRow = $(this);
            var targetId = calendarRow.attr('id');
            var itemInList;
            $('#mealplanItemList li').each(function() {
                itemInList = $(this);
                if (this.getAttribute('data-item-mealplan')== targetId) {
                    if (this.getAttribute('data-category') == "Breakfast") {
                        if(this.hasAttribute('data-item-name')) {
                            var item = this.getAttribute('data-item-name');
                        }
                        if(this.hasAttribute('data-item-recipe')) {
                            var item = this.getAttribute('data-item-recipe');
                        }
                        var id = this.getAttribute('data-item-id');
                        var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                            "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                            "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                            "</form></li>";
                        breakfastSection.append(content);
                    };
                    if (this.getAttribute('data-category') == "Lunch") {
                        if(this.hasAttribute('data-item-name')) {
                            var item = this.getAttribute('data-item-name');
                        }
                        if(this.hasAttribute('data-item-recipe')) {
                            var item = this.getAttribute('data-item-recipe');
                        }
                        var id = this.getAttribute('data-item-id');
                        var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                            "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>"+
                            "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                            "</form></li>";
                        lunchSection.append(content);
                    };
                    if (this.getAttribute('data-category') == "Dinner") {
                        if(this.hasAttribute('data-item-name')) {
                            var item = this.getAttribute('data-item-name');
                        }
                        if(this.hasAttribute('data-item-recipe')) {
                            var item = this.getAttribute('data-item-recipe');
                        }
                        var id = this.getAttribute('data-item-id');
                        var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                            "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                            "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                            "</form></li>";
                        dinnerSection.append(content);
                    };
                    if (this.getAttribute('data-category') == "Snacks") {
                        if(this.hasAttribute('data-item-name')) {
                            var item = this.getAttribute('data-item-name');
                        }
                        if(this.hasAttribute('data-item-recipe')) {
                            var item = this.getAttribute('data-item-recipe');
                        }
                        var id = this.getAttribute('data-item-id');
                        var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                            "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                            "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                            "</form></li>";
                        snacksSection.append(content);
                    };
                };
                return itemInList;
            });


            $('.addMealplanItemButton').click(function() {
                var target = this.closest('.fc-day-header').getAttribute('data-date');
                $("#MealplanItem_mealplanId").val(target); 
            });
            var element;
            $('.delete-item-button').on('click', function(event) {
                event.preventDefault();
                element = $(this).closest('li');
                element.find('.delete-form').submit();
            });
            $('.delete-form').ajaxForm({
                success: function() {
                    element.remove();
                    itemInList.remove();
                }
            });
        });
    });
});



function searchMealplanItems(breakfastSection, lunchSection, dinnerSection, snacksSection, calendarRow, targetId) {
    $('#mealplanItemList li').each(function() {
        if (this.getAttribute('data-item-mealplan')== targetId) {
            if (this.getAttribute('data-category') == "Breakfast") {
                if(this.hasAttribute('data-item-name')) {
                    var item = this.getAttribute('data-item-name');
                }
                if(this.hasAttribute('data-item-recipe')) {
                    var item = this.getAttribute('data-item-recipe');
                }
                var id = this.getAttribute('data-item-id');
                var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                    "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                    "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                    "</form></li>";
                breakfastSection.append(content);
            };
            if (this.getAttribute('data-category') == "Lunch") {
                if(this.hasAttribute('data-item-name')) {
                    var item = this.getAttribute('data-item-name');
                }
                if(this.hasAttribute('data-item-recipe')) {
                    var item = this.getAttribute('data-item-recipe');
                }
                var id = this.getAttribute('data-item-id');
                var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                    "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>"+
                    "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                    "</form></li>";
                lunchSection.append(content);
            };
            if (this.getAttribute('data-category') == "Dinner") {
                if(this.hasAttribute('data-item-name')) {
                    var item = this.getAttribute('data-item-name');
                }
                if(this.hasAttribute('data-item-recipe')) {
                    var item = this.getAttribute('data-item-recipe');
                }
                var id = this.getAttribute('data-item-id');
                var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                    "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                    "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                    "</form></li>";
                dinnerSection.append(content);
            };
            if (this.getAttribute('data-category') == "Snacks") {
                if(this.hasAttribute('data-item-name')) {
                    var item = this.getAttribute('data-item-name');
                }
                if(this.hasAttribute('data-item-recipe')) {
                    var item = this.getAttribute('data-item-recipe');
                }
                var id = this.getAttribute('data-item-id');
                var content = "<li class='list-group-item text-center'>" + item + " <a class='delete-item-button' href='#'>" + 
                    "<span title='Delete from Mealplan' class='fa fa-remove pull-right' aria-hidden='true'></span></a>" +
                    "<form class='delete-form' action='/mealplan/item_delete/"+ id +"' method='POST'>" +
                    "</form></li>";
                snacksSection.append(content);
            };
        };
    });
}