$(document).ready(function(){
    $('#add_btn').click(function(){
        var html;
        var grocerys = [];
        $.each($(".selectpicker option:selected"), function() {
            grocerys.push($(this).val());
        });
       grocerys.forEach(function(meal) {
            //html += '<li class="list-group-item">' + meal + '</li>';
            $('.list-group').append('<li class="list-group-item">' + meal + 
                '<a><span title="Delete from grocerylist" class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span></a></li>' );
       });
       //$('.list-group').append(html);
       $('.selectpicker').selectpicker('deselectAll');
    });

    $('.glyphicon-remove').click(function(){
        alert("HI");
        var item = $(this).parent('.list-group-item');
        item.remove();

    });
});

