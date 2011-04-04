/**
 *  Quote Rotator plugin for jQuery
 *  @author   Chris Pappas <cpappas@hepcom.ca>
 *  @version  0.2
 *  @date     2011-02-09
 */
;(function($) {
  $.fn.rotateQuotes = function(options) {
      
    var opts = $.extend({}, $.fn.rotateQuotes.defaults, options);
    
    var current_index = 0;
    
    return this.each(function() {
      
          var blocks = $(this).children();
        
          if (blocks.size() > 1) {
            blocks.first().show();        // make sure the first one is shown
            blocks.not(':first').hide();  // make sure the rest are hidden
            
            var current = blocks.first();
            
            // run the rotateQuotes function according to display_duration
            window.setInterval(
                function() {
                    current.fadeOut(opts.outSpeed);
                    current.detach().appendTo(blocks.parent());
                    current = blocks.parent().children().first();
                    current.delay(opts.animationDelay).fadeIn(opts.inSpeed);
                },
                opts.displayDuration
            );
          } // end if
      
    });
  };
  
  $.fn.rotateQuotes.defaults = {
    outSpeed: 500,          // 0.5 seconds, the speed at which the "hide" animation runs
    inSpeed: 500,           // 0.5 seconds, the speed at which the "show" animation runs
    displayDuration: 5000,  // 5 seconds, how long the item will be displayed
    animationDelay: 600    // 0.6 seconds, the delay between the "hide" and "show" animation events
  };

})(jQuery);
