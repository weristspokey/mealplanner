$(document).ready(function(){
     // Selection in Add Meal Form
    disableRecipeSelect();

    $(".food").click(function() {
        enableFoodSelect();
        disableRecipeSelect();
    });
    $(".recipe").click(function() {
        enableRecipeSelect();
        disableFoodSelect();
    });

    $('#recipes-gallery').jplist({             
        itemsBox: '.thumbnail-gallery', 
        itemPath: '.item', 
        panelPath: '.jplist-panel'    
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

    $('td.fc-day').each(function() {
        var breakfastSection = $(this).find('.breakfast-section');
        var lunchSection = $(this).find('.lunch-section'); 
        var dinnerSection = $(this).find('.dinner-section'); 
        var snacksSection = $(this).find('.snacks-section'); 
        //breakfastSection.html("na");
        var calendarRow = $(this);
        var targetId = calendarRow.attr('id');
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
    });

    var element;
    $('.delete-item-button').on('click', function(event) {
        event.preventDefault();
        element = $(this).closest('li');
        element.find('.delete-form').submit();
    })
    $('.delete-form').ajaxForm({
        success: function() {
            element.remove();
        }
    });
});

function disableFoodSelect() {
    $(".food").removeClass('active');
    $(".food-select").prop('disabled', true);
}
function disableRecipeSelect() {
    $(".recipe").removeClass('active');
    $(".btn-group.recipe-select").addClass('disabled');
    $(".btn-group.recipe-select").find('.btn').addClass('disabled');
    $(".selectpicker.recipe-select").attr('disabled', 'true');
}
function enableFoodSelect() {
    $(".food").addClass('active');
    $('.food-select').prop('disabled', false);
}
function enableRecipeSelect() {
    $(".recipe").addClass('active');
    $(".btn-group.recipe-select").removeClass('disabled');
    $(".btn-group.recipe-select").find('.btn').removeClass('disabled');
    $(".selectpicker.recipe-select").removeAttr('disabled');
}