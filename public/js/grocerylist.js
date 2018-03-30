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

//     $(".add-item-form").submit(function(event) {
//         event.preventDefault();
//         var item = $('input[name=item]').val();
//         element = '<li class="list-group-item text-center">' +
//                         '<a data-toggle="modal" data-target="#MoveItemModal" class="moveItemBtn">' +
//                             '<span title="Add to Kitchen" class="fa fa-arrow-left pull-left" aria-hidden="true"></span>' +
//                         '</a>' + item +
//                         '<a href="#" class="delete-button">' +
//                             '<span title="Delete from grocerylist" class="fa fa-remove pull-right" aria-hidden="true"></span>' +
//                         '</a>' +
//                         '<form class="delete-form" action="{{ path(\'grocerylistItem_delete\', {\'id\': item.id }) }}" method="POST"></form>' +
//                     '</li>';
//         // Get input field values


//             $(this).closest('ul').append(element);
// });

});

