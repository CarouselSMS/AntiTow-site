  $(document).ready(function(){
    $("#switch").click(function(){
      $.scrollTo( '#header', 800 );
  });
    $("#switch").toggle(function () { 
      $("#header")
      .css({'background-image': 'url(<?php bloginfo('stylesheet_directory'); ?>/images/logo2-with-border.png)'});
      }, function() {
      $("#header").css({'background-image': 'url(<?php bloginfo('stylesheet_directory'); ?>/images/logo_w_border.png)'});
    });
  });