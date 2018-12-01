$(document).ready(function(){
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('input:first').focus();
    });
    $('.moveItemBtn').click(function() {
        var itemId = this.getAttribute('data-item-id');
        var itemName = this.getAttribute('data-item-name');
        $('input[name=itemId]').val(itemId);
        $('#form_name').val(itemName);
    });

    var element;
    $('.delete-grocerylist-item-button').on('click', function(event) {
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

