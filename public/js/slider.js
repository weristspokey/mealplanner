$(document).ready(function(){
  $('#mealplanSlider').bxSlider({
    slideWidth: 300,
    minSlides: 1,
    maxSlides: 2,
    moveSlides: 1,
    slideMargin: 20,
    infiniteLoop: false
  });
  $('#recipesSlider').bxSlider({
    slideWidth: 300,
    minSlides: 1,
    maxSlides: 1,
    moveSlides: 1,
    slideMargin: 20,
    infiniteLoop: false
  });
  $('.addMealplanItemBtn').click(function() {
    var target = $(this).attr('rel');
    //$("#"+target).show();
    $("#"+target).show();
  });
  $('.close-addMealplanItemForm').click(function() {
    $(this).closest('.slide').hide();
  });

  $('.addMealplanItemButton').click(function() {
    var target = this.closest('.fc-day-header').getAttribute('data-date');
    $("#MealplanItem_mealplanId").val(target); 
    //document.getElementById('MealplanItem_mealplanId').val(target);
    //$("#"+target).show();
    //$("#"+target).show();
    //alert(target);
  });
});

/*
function has_header_injection($str) {
    return preg_ḿatch("/[\r\n]/", $str);
}

$('#submit_register_btn').click(function () {
    name = trim($_POST['username']);
    email = trim($_POST['email']);
    if (has_header_injection($name) || has_header_injection($email)) {
        die();
    }
    if (!name || !email) {
        echo '<p>required</p>';
    }

    $recipient = "sabse@sabse.com";
    $subject = "$name sent you a message";
    $message = "Name : $name\r\n";
    $message .= "Message : \r\n $msg";

});*/
