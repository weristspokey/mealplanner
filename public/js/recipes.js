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
});

    // $("#app_user_plainPassword_first").keyup(function() 
    // {
    //     var $content = $("#app_user_plainPassword_first").val();
    //     if ($content == "")
    //     {
    //         var $text = document.getElementById("sicherheitshinweise").innerHTML="keine Eingabe";
    //         return $text;
    //     }
    //     if (window.XMLHttpRequest)
    //     {
    //     // AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera
    //         var xmlhttp = new XMLHttpRequest();
    //     }
    //     xmlhttp.onreadystatechange=function()
    //     {
    //         if (xmlhttp.readyState==4 && xmlhttp.status==200)
    //         {
    //             document.getElementById("sicherheitshinweise").innerHTML=xmlhttp.responseText;
    //         }
    //     }
    //     xmlhttp.open("GET","/"+$content,true);
    //     xmlhttp.send();
    // });

    // $(".js-attend-toggle").click(function(){
    //     $.ajax({url: "grocerylist", async: false, success: function(result){
    //         $("div").html(result);
    //     }});
    // });

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