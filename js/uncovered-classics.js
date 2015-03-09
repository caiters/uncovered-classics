(function(){
  if( jQuery('#gallery-1').length ){
    jQuery('.gallery-icon > a').magnificPopup({
      type: 'image',
      gallery: {
        enabled:true
      },
      image: {
        titleSrc: function(item) {
          var el = jQuery(item.el[0]);
          var thetitle = el.parent('.gallery-icon').siblings('.gallery-item-title').html();
          var thecaption = el.parent('.gallery-icon').siblings('.gallery-caption').html();
          var thedescription = el.parent('.gallery-icon').siblings('.gallery-item-description').html();
          var allofit = '<h2><span class="gallery-item-title">' + thetitle + '</span> | <span class="gallery-item-illustrator">' + thecaption + '</span></h2><p>' + thedescription + '</p>';
          console.log('caption:' + allofit);
          return allofit;
        }
      }

    });
  }
})();
