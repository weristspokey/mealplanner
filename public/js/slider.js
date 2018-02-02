$(document).ready(function(){
  $('#mealplanSlider').bxSlider({
    slideWidth: 300,
    minSlides: 1,
    maxSlides: 6,
    moveSlides: 1,
    slideMargin: 2,
    infiniteLoop: false
  });
  $('#recipesSlider').bxSlider({
    slideWidth: 200,
    minSlides: 2,
    maxSlides: 3,
    slideMargin: 10
  });
  $('.addMealplanItemBtn').click(function() {
    var target = $(this).attr('rel');
    $("#"+target).show();
  });
  $('.close-addMealplanItemForm').click(function() {
    $(this).closest('.col-md-4').hide();
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
