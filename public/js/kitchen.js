$(document).ready(function(){
    $('.moveItemBtn').click(function() {
        //e.preventDefault();
        var itemId = this.getAttribute('data-item-id');
        var foodId = this.getAttribute('data-food-id');
        $('input[name=itemId]').val(itemId);
        $('#form_foodId').val(foodId);
        $('#form_foodId').selectpicker('refresh');
    });
});

