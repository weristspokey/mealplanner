$(document).ready(function(){
    $("#addRecipeItemBtn").click(function() {
        $(".recipeItemsRow").toggle();
    });
    $("#addGrocerylistItemBtn").click(function() {
        $(this).css('display', 'none');
        $(this).next().css('display', '');
    });
    $(".alert").delay(4000).slideUp(2000, function(){
        $(this).alert('close');
    });


    disableRecipeSelect();

    $(".btn-group.food-select").find('.btn').click(function() {
        enableFoodSelect();
        disableRecipeSelect();
    });
    $(".btn-group.recipe-select").find('.btn').click(function() {
        enableRecipeSelect();
        disableFoodSelect();
    });

    $('#recipes-gallery').jplist({             
        itemsBox: '.thumbnail-gallery', 
        itemPath: '.item', 
        panelPath: '.jplist-panel'    
    });

    $("#app_user_plainPassword_first").keyup(function() 
     {
        var $content = $("#app_user_plainPassword_first").val();
        if ($content.length < 6)
        {
            var $text = document.getElementById("sicherheitshinweise").innerHTML="ZU WENIG";
            return $text;
        }
        if ($content.length > 5)
        {
            var $text = document.getElementById("sicherheitshinweise").innerHTML="";
            return $text;
        }
    });

    var element;
    $('.delete-recipe-item-button').on('click', function(event) {
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
    $(".btn-group.food-select").addClass('disabled');
    $(".btn-group.food-select").find('.btn').addClass('disabled');
    $(".selectpicker.food-select").attr('disabled', 'true');
}
function disableRecipeSelect() {
    $(".btn-group.recipe-select").addClass('disabled');
    $(".btn-group.recipe-select").find('.btn').addClass('disabled');
    $(".selectpicker.recipe-select").attr('disabled', 'true');
}
function enableFoodSelect() {
    $(".btn-group.food-select").removeClass('disabled');
    $(".btn-group.food-select").find('.btn').removeClass('disabled');
    $(".selectpicker.food-select").removeAttr('disabled');
}
function enableRecipeSelect() {
    $(".btn-group.recipe-select").removeClass('disabled');
    $(".btn-group.recipe-select").find('.btn').removeClass('disabled');
    $(".selectpicker.recipe-select").removeAttr('disabled');
}