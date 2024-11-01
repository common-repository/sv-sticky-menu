/************************************
 * Additional functionality helper script v0.9
 * 
 * Copyright 2017-2020 Andrey Svyatovets
 *
 ***********************************/

//==============================================
// Sticky Menu functionality. 
//==============================================

jQuery(document).ready(function () {
        var object = jQuery(SVSTDDATA.selector);

        if ( !object.length )  
           return;

        var stickyNavTopMD = object.offset().top + object.height(); // Top position

        if (window.pageYOffset >= stickyNavTopMD && window.innerWidth > SVSTDDATA.min_media) 
             AddSticky ();

        window.addEventListener('scroll', function () {
            //var object = $(SVSTDDATA.selector);
            if (window.pageYOffset >= stickyNavTopMD && window.innerWidth > SVSTDDATA.min_media) 
                AddSticky ();
            else {
               if (object.hasClass('fixedmenu') && window.pageYOffset <= stickyNavTopMD - object.height() ) 
                 RemoveSticky ();   
            }
        });
        window.addEventListener('resize', function () {
           if (object.hasClass('fixedmenu') && window.innerWidth <= SVSTDDATA.min_media ) 
                RemoveSticky ();   
            else if (window.pageYOffset >= stickyNavTopMD && window.innerWidth > SVSTDDATA.min_media)
                AddSticky ();
        });
});

function AddSticky () {
    var object = jQuery(SVSTDDATA.selector);
    var object_hide = jQuery(SVSTDDATA.selector_hide);
    if (!object.hasClass('fixedmenu')) 
    {
       // add div for smooth scrolling of content
       object.parent().append("<div id='sticky-shift' style='height:" + object.height() + "px;'></div>");
         
        if ( object_hide.length )  
       		object_hide.hide();

       // add logo
       if (SVSTDDATA.logo=='true') {
            var zindex = parseInt(SVSTDDATA.zindex) + 1;
  	    object.prepend ("<a id='sticky-logo-link' href='"+ SVSTDDATA.logo_url + "' style='z-index:"+ zindex + ";' ><img id='sticky-logo' src='"+ SVSTDDATA.logo_img + "' ></img></a>");
       }

       // Make menu fixed 
        object.addClass('fixedmenu').addClass('outside');

       // Transition
       setTimeout(function() {
	 object.addClass('fixedtransition').removeClass('outside').addClass('onside');
         object.addClass('sticky-transparency');
         if (SVSTDDATA.shadow=='true')   
             object.addClass('sticky-shadow');
       }, 50);        
    }
}
function RemoveSticky () {
	setTimeout(function() {
           var object = jQuery(SVSTDDATA.selector);
    	   var object_hide = jQuery(SVSTDDATA.selector_hide);

          if ( object_hide.length )  
       	     object_hide.show();

          object.removeClass('fixedmenu') 
                .removeClass('outside')
        	.removeClass('onside')
                .removeClass('fixedtransition')
		.removeClass('sticky-transparency')
		.removeClass('sticky-shadow')
		.css({'top': ''});
       	        jQuery('#sticky-shift').remove();

       	   if (SVSTDDATA.logo=='true') {
              jQuery('#sticky-logo-link').remove();
              //jQuery('#sticky-logo').remove();
           }

	}, 50);        
}