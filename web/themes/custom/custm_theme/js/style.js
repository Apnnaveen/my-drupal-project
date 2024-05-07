(function ($, Drupal) {
    Drupal.behaviors.myCustomBehavior = {
      attach: function (context, settings) {
        $("p", context).fadeOut(100);
        $("p", context).fadeIn(1000);
  
        $(".box", context).slideUp();
        $(".box", context).slideDown(5000);
  
        $("p", context).click(function () {
          $(this).hide();
        });
      }
    };
  })(jQuery, Drupal);
  