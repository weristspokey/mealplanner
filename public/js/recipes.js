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

    $('.serving-nav .nav-item .nav-link').click(function(event) {
        event.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        var multiplikator = this.getAttribute('data-value');
        $('.item-value').each(function(){
            var value = parseInt($(this).html());
            $(this).html(value * multiplikator);
        });

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