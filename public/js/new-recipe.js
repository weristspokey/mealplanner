$(document).ready(function(){
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