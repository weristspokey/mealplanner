$(document).ready(function(){
    $('.moveItemBtn').click(function() {
        //e.preventDefault();
        var itemId = this.getAttribute('data-item-id');
        var foodId = this.getAttribute('data-food-id');
        $('input[name=itemId]').val(itemId);
        $('#form_foodId').val(foodId);
        $('#form_foodId').selectpicker('refresh');
    });

    var element;
    $('.delete-button').on('click', function(event) {
        event.preventDefault();
        element = $(this).closest('li');
        element.find('.delete-form').submit();
    })
    $('.delete-grocerylist-button').on('click', function(event) {
        event.preventDefault();
        element = $(this).closest('.col-md-3');
        element.find('.delete-form').submit();
    })
    $('.delete-form').ajaxForm({
        success: function() {
            element.remove();
        }
    });
});

