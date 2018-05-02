$(document).ready(function(){
    $('.delete-user-button').on('click', function(event) {
        event.preventDefault();
        element = $(this).closest('tr');
        element.find('.delete-form').submit();
    })
    $('.delete-form').ajaxForm({
        success: function() {
            element.remove();
        }
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

    var waypoint = new Waypoint({
        element: document.getElementById('goals'),
        handler: function(direction) {
             $('.counter').countTo();
        }
    });
});
