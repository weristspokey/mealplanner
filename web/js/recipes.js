$(document).ready(function(){
  $('.img-thumbnail').mouseenter(
    function() {
      $('.box').css('display', '');
  });
  $('.img-thumbnail').mouseleave(
    function() {
      $('.box').css('display', 'none');
  });
  
});