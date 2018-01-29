$(document).ready(function(){
  $("#addRecipeItemBtn").click(function() {
    $(".recipeItemsRow").css('display', '');
});
  $("#addGrocerylistItemBtn").click(function() {
    $(this).css('display', 'none');
    $(this).next().css('display', '');
});
});