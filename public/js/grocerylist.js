$(document).ready(function(){
    $('.moveItemBtn').click(function() {
        //e.preventDefault();
        var itemId = this.getAttribute('data-item-id');
        var foodId = this.getAttribute('data-food-id');
        $('input[name=itemId]').val(itemId);
        $('#form_foodId').val(foodId);
        $('#form_foodId').selectpicker('refresh');
    });

    $("#deleteGrocerylistBtn").click(function() 
     {
        var $id = this.getAttribute('data-item-id');
        bootbox.confirm("Are you sure?", function(result) {
            url = "{{ path('grocerylist_delete', {'id': grocerylist.id }) }}";
            url = $url.replace("0",$id);
            if(result){
                $.ajax({ 
                    url: url,
                    type: 'delete', 
                    success: function(result) {
                        console.log('Delete');
                    },
                    error: function(e){
                        console.log(e.responseText);
                    }
                });
            }
        });
    });

    $("#deleteGrocerylistBtn").click(function(){
        $.ajax({
            url: "{{ path('grocerylist_delete', {'id': grocerylist.id }) }}",
            async: false, 
            success: function(result){
            $("div").html(result);
        }});
    });
});

