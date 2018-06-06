$(document).ready(function(){
     $('.modal').on('shown.bs.modal', function() {
        $(this).find('input:first').focus();
    });
        $('.moveItemBtn').click(function() {
        //e.preventDefault();
        var itemId = this.getAttribute('data-item-id');
        var itemName = this.getAttribute('data-item-name');
        $('input[name=itemId]').val(itemId);
        $('#form_name').val(itemName);
    });
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

    $('#recipes-gallery').jplist({             
        itemsBox: '.thumbnail-gallery', 
        itemPath: '.item', 
        panelPath: '.jplist-panel'    
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

    $('#app_recipe_Submit').click(function() {
        var tags = [];
        $('#tags-select').find('option:selected').each(function() {
            tags.push($(this).data("id"));
        });
        $('#app_recipe_tags').val(tags);
    });

    var recipeTags = $('#app_recipe_tags').val().split(',');
    for(var i=0; i < recipeTags.length; i++) {
        recipeTags[i] = parseInt(recipeTags[i], 10);
    }
    
    $('#tags-select').find('option').each(function() {
        if(recipeTags.includes($(this).data("id"))){
            $(this).attr('selected', true);
        }
        $('#tags-select').selectpicker('refresh');
    });
});