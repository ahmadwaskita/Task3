(function($) {
  // Add the function to jquery, handle the options
  $.fn.nxtBox = function(options) {
    options = $.extend({}, $.fn.nxtBox.defaults, options);

    return this.each(function() {
      $(this).click(function(event) {

        var scroll = $(document).scrollTop();
        console.log('Clicked a image, displaying lightbox');

        $('<div id="lightbox"></div>')
          .css("opacity", options.opacity)
          .prependTo('body');

        if(options.scrollbar === false) {
          $('body').css("overflow-y", "hidden");
        }

        $('<div id="lightboximage"></div>')
          .html(
            $('<img>')
            .addClass('lightbox')
            .css("max-width", ($(window).width() / 2 + 200))
            .attr('src', $(this).attr('src'))
            .attr('alt', $(this).attr('alt')))
        .prependTo('body');

        $('#lightboximage').click(function(event) {
          var target = $(event.target);

          if(options.invertclose === true) {
            if(target.is("div") || target.is("p")) {
              return;
            }
          }
          else {
            if(target.is("img") || target.is("p")) {
              return;
            }
          }
          event.preventDefault();
          removeLightBox();
        });

        $('<p class="lb-description"></p>')
          .text($('.lightbox').attr('alt'))
          .css("width", ($(window).width() / 2 + 160))
          .append('<a href="" class="close">x</a>')
          .insertAfter('.lightbox');
      });
    });

  };

  $(window).resize(function() {
    $('#lightboximage img').css("max-width", ($(window).width() / 2 + 200));
    // Caption is smaller in width than img, remove 40pxs
    $('#lightboximage p').css("width", ($(window).width() / 2 + 160));
  });

  var removeLightBox = function() {
    console.log('Removing n9xtbox elements');
    $('body #lightbox').remove();
    $('#lightboximage').empty().remove();
    $('body').css("overflow-y", "visible");
  };

  $.fn.nxtBox.defaults = {
    'scrollbar': true,
    'opacity': 0.8,
    'invertclose': false
  };

})(jQuery);
