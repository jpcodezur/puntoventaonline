if (window.jQuery && jQuery.noConflict && (typeof $('body') == 'object')) {
	jQuery.noConflict();
/**
	 * ja tabs plugin
	 */

	jQuery.cookie = function(name, value, options) {
		if (typeof value != 'undefined') { // name and value given, set cookie
			options = options || {};
			if (value === null) {
				value = '';
				options.expires = -1;
			}
			var expires = '';
			if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
				var date;
				if (typeof options.expires == 'number') {
					date = new Date();
					date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
				} else {
					date = options.expires;
				}
				expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
			}
			// CAUTION: Needed to parenthesize options.path and options.domain
			// in the following expressions, otherwise they evaluate to undefined
			// in the packed version for some reason...
			var path = options.path ? '; path=' + (options.path) : '';
			var domain = options.domain ? '; domain=' + (options.domain) : '';
			var secure = options.secure ? '; secure' : '';
			document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
		} else { // only name given, get cookie
			var cookieValue = null;
			if (document.cookie && document.cookie != '') {
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = jQuery.trim(cookies[i]);
					// Does this cookie string begin with the name we want?
					if (cookie.substring(0, name.length + 1) == (name + '=')) {
						cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
						break;
					}
				}
			}
			return cookieValue;
	
		}
	};



	(function($) { 
				$.fn.jaContentTabs = function (_options){
					return this.each( function() {		
						var container = $( this );
						new $.jaContentTabs().setup( this, container );
					} );
				}
				 $.jaContentTabs = function() { 
					var self = this;
					this.lastTab = null;
					this.nextTab=null;
					this.setup=function( obj, o ){
						var contentTabs = o.children( 'div.ja-tab-content' );
						var nav = o.children( 'ul.ja-tab-navigator' );
						contentTabs.children('div').hide();
						nav.children('li:first').addClass('first').addClass( 'active' );	
						contentTabs.children('div:first').show();
						
						nav.children('li').children('a').click( function() {
							self.lastTab = 	nav.children('li.active').children('a').attr('href');										
							nav.children('li.active').removeClass('active')											
							$(this).parent().addClass('active');
							var currentTab = $(this).attr('href'); 
							self.tabActive( contentTabs, currentTab );		
							return false;
						});	
					};
					this.tabActive=function( contentTabs,  currentTab ){
						if(  this.lastTab != currentTab ){
							contentTabs.children( this.lastTab ).hide();	
						}
			
						contentTabs.children( currentTab ).show();
					};
				};
			})(jQuery);

		(function($){
		   	equalheight = function(container){
				var currentTallest = 0,
				     currentRowStart = 0,
				     rowDivs = new Array(),
				     $el,
				     topPosition = 0;
				 $(container).each(function() {

				   $el = $(this);
				   $($el).height('auto')
				   topPostion = $el.position().top;

				   if (currentRowStart != topPostion) {
				     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
				       rowDivs[currentDiv].height(currentTallest);
				     }
				     rowDivs.length = 0; // empty the array
				     currentRowStart = topPostion;
				     currentTallest = $el.height();
				     rowDivs.push($el);
				   } else {
				     rowDivs.push($el);
				     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
				  }
				   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
				     rowDivs[currentDiv].height(currentTallest);
				   }
				 });
				}

				$(window).load(function() {
				  equalheight('.catalog-category-view .category-products li.item .inner');
				});


				$(window).resize(function(){
				  equalheight('.catalog-category-view .category-products li.item .inner');
				});
		})(jQuery);
}
(function($){
   	equalheight = function(container){
		var currentTallest = 0,
		     currentRowStart = 0,
		     rowDivs = new Array(),
		     $el,
		     topPosition = 0;
		 $(container).each(function() {

		   $el = $(this);
		   $($el).height('auto')
		   topPostion = $el.position().top;

		   if (currentRowStart != topPostion) {
		     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
		       rowDivs[currentDiv].height(currentTallest);
		     }
		     rowDivs.length = 0; // empty the array
		     currentRowStart = topPostion;
		     currentTallest = $el.height();
		     rowDivs.push($el);
		   } else {
		     rowDivs.push($el);
		     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		  }
		   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
		     rowDivs[currentDiv].height(currentTallest);
		   }
		 });
		}

		$(window).load(function() {
		  equalheight('.products-grid .pdescription');
		});


		$(window).resize(function(){
		  equalheight('.products-grid .pdescription');
		});
})(jQuery);
function switchTool (ckname, val) {
	createCookie(ckname, val, 365);
	window.location.reload();
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function menuFistLastItem () {
	if ((menu = $('nav')) && (children = menu.childElements()) && (children.length)) {
		children[0].addClassName ('first');
		children[children.length-1].addClassName ('last');
	}
}
function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}
jQuery(window).load(function(){
	
    mainpadding = jQuery("#ja-header .main .inner").offset().left;
    jQuery("li.haschild div.childcontent").each(function(index,childcontent){
         jQuery(childcontent).css("margin-left",0-mainpadding);
         jQuery(childcontent).css("width",jQuery("#ja-header").width());
    })
})
document.observe("dom:loaded", function() {
    //alert(jQuery("#ja-container").width() - jQuery("#ja-container .main").width());
    //alert(jQuery("#ja-container .main").offset().left);
    //add back to top button
    
    backtotop = jQuery('<a href="#Top" class="btn-btt" title="Back to Top" id="button-btt" style="display: inline;">Top</a>');
	backtotop.appendTo('#ja-container');
	// hide #back-top first
	backtotop.hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				backtotop.fadeIn();
			} else {
				backtotop.fadeOut();
			}
		});

		// scroll body to 0px on click
		backtotop.click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

    
    
	menuFistLastItem();
	jQuery(".block-content .currently ol").children().last().addClass("last");
	
	if(detectmob()){
		 jQuery("#ja-search .btn-toggle").bind("click",function(){
                if(jQuery("#jmoverlay").length <= 0){
						jmoverlay = jQuery('<div id="jmoverlay" class="jmoverlay"></div>'); 
						jmoverlay.appendTo('#ja-wrapper');
						jmoverlay.bind("click",function(){
							jQuery(".has-toggle .btn-toggle").removeClass("active");
							jQuery(".btn-toggle").siblings(".inner-toggle").removeClass("inneractive");	
							this.remove();
						})
			     }
			     jQuery(".btn-toggle").not(this).siblings(".inner-toggle").removeClass("inneractive");													  	        
			     jQuery(this).siblings(".inner-toggle").toggleClass("inneractive");

		 });
         jQuery("#ja-mycart,#ja-quickaccess,#ja-quicksetting").bind("click",function () {
		   
			$this = jQuery(this).find(".btn-toggle");
			if(jQuery("#jmoverlay").length <= 0){
				jmoverlay = jQuery('<div id="jmoverlay" class="jmoverlay"></div>'); 
				jmoverlay.appendTo('#ja-wrapper');
				jmoverlay.bind("click",function(){
					jQuery("#ja-mainnav-inner").css({"left":"0"});							
					jQuery(".has-toggle .btn-toggle").removeClass("active");
					jQuery(".btn-toggle").siblings(".inner-toggle").removeClass("inneractive");	
					this.remove();
				})
			}	
			
			jQuery(".btn-toggle").not($this).siblings(".inner-toggle").removeClass("inneractive");													  	        
			jQuery($this).siblings(".inner-toggle").toggleClass("inneractive");
			jQuery(".btn-toggle").not($this).removeClass("active");													  	            
			jQuery($this).toggleClass("active");
			if(!jQuery($this).hasClass("active") && jQuery("#jmoverlay").length > 0){
				jQuery("#jmoverlay").remove();
			} 
			if(window.sidebarIScroll){
		       window.sidebarIScroll.refresh();
	        }
		});

	   
	}else{

	    jQuery("#ja-mycart,#ja-quickaccess,#ja-quicksetting").hover(function () {
		  
			$this = jQuery(this).find(".btn-toggle");
			if(jQuery("#jmoverlay").length <= 0){
				jmoverlay = jQuery('<div id="jmoverlay" class="jmoverlay"></div>'); 
				jmoverlay.appendTo('#ja-wrapper');
				jmoverlay.bind("click",function(){
					jQuery("#ja-mainnav-inner").css({"left":"0"});							
					jQuery(".has-toggle .btn-toggle").removeClass("active");
					jQuery(".btn-toggle").siblings(".inner-toggle").removeClass("inneractive");	
					this.remove();
				})
			}	
			
			jQuery(".btn-toggle").not($this).siblings(".inner-toggle").removeClass("inneractive");													  	        
			jQuery($this).siblings(".inner-toggle").toggleClass("inneractive");
			jQuery(".btn-toggle").not($this).removeClass("active");													  	            
			jQuery($this).toggleClass("active");
			if(!jQuery($this).hasClass("active") && jQuery("#jmoverlay").length > 0){
				jQuery("#jmoverlay").remove();
			} 
			if(window.sidebarIScroll){
		       window.sidebarIScroll.refresh();
	        }
		},function(){
			$this = jQuery(this).find(".btn-toggle");
			$this.removeClass("active");	
			$this = jQuery(this).find(".btn-toggle");
			jQuery($this).siblings(".inner-toggle").removeClass("inneractive");
			if(jQuery("#jmoverlay").length){
				jQuery("#jmoverlay").remove();
			}	
			
		});
     }
	 jQuery("ul.level0").children("li.haschild").hover(function(){
           if(jQuery("#jmoverlay").length <= 0){
				jmoverlay = jQuery('<div id="jmoverlay" class="jmoverlay"></div>'); 
				jmoverlay.appendTo('#ja-header .main');
			}	    
	 },function(){
           if(jQuery("#jmoverlay").length){
				jQuery("#jmoverlay").remove();
			}  
			
          
	 })

     wwidth = jQuery(window).width();
	
	   
	  jQuery(window).resize (function() {
		   if(window.shopbyIScrol && window.shopbyIScrol !== undefined)	{
			     window.shopbyIScrol.destroy();
			     window.shopbyIScrol  = null;
			}					  
		   wwidth = jQuery(window).width();	
		   if(wwidth <= 985 && window.sidebarIScroll == undefined){
			  window.sidebarIScroll = new iScroll('ja-mainnav-inner',{vScrollbar: true, useTransform: true,hScrollbar: false});  
		   }else if(window.sidebarIScroll !== undefined && window.sidebarIScroll !== null){
			  jQuery('#jm-megamenu').removeAttr('style');
			  jQuery("#ja-mainnav .btn-toggle").removeClass("active");
			  window.sidebarIScroll.destroy();
			  window.sidebarIScroll = null;
		   }						 
	  });
	  jQuery("#ja-mainnav .btn-toggle").on("click",function(event){
			  event.stopPropagation();
			  wwidth = jQuery(window).width();
			  mainnavos = jQuery("#ja-mainnav-inner").offset();
			  totalwidth = mainnavos.left + jQuery("#ja-mainnav-inner").width();
			  
              if(totalwidth > wwidth){
				  left =  wwidth-totalwidth-5;
				  jQuery("#ja-mainnav-inner").css({"left":left});
			  }
			  if(jQuery(this).attr("class").indexOf("active") < 0){
				  jQuery("#ja-mainnav-inner").css({"left":0});
			  }
			  if(wwidth > 985) { 
			     if(window.childcontentIScrol)
			     return  false;
			  }
			  updatemenuheight();			  
	  });
      if(detectmob()){ 
		        jQuery("#ja-quickaccess .btn-toggle").click(function(e){
				 		jQuery("#ja-quickaccess").toggleClass("active");
						if(jQuery("#ja-quickaccess").hasClass("active")){
				                if(window.myaccountIScrol !== undefined && window.myaccountIScrol !== null){
							         window.myaccountIScrol.destroy();
							         window.myaccountIScrol  = null;
							    }
							   	 if(jQuery("#myaccountscroll").length){
							   	  windowheight = jQuery(window).height()-jQuery("#ja-header").height();
                                  windowheight = windowheight - parseInt(jQuery("#ja-quickaccess .inner-toggle").css("padding-top"));
                                  jQuery("#myaccountscroll").css("height",windowheight);
							   	  setTimeout(function(){
							   	      window.myaccountIScrol = new iScroll("myaccountscroll",{vScrollbar: true, useTransform: true,hScrollbar: false});	
							   	  },100);	
								 }else{
					                quickaccess = jQuery("#ja-quickaccess .inner-toggle").html();
					                myaccount = jQuery('<div calss="inner-togglecontent" />').append(jQuery("#ja-quickaccess .inner-toggle").html());
					                myaccount.css({float:"left",height:"auto"});
					                jQuery("#ja-quickaccess .inner-toggle").html("");
					                myaccountscroll = jQuery('<div id="myaccountscroll" />');
					                myaccount.appendTo(myaccountscroll);
					               
					                windowheight = jQuery(window).height()-jQuery("#ja-header").height();
                                    windowheight = windowheight - parseInt(jQuery("#ja-quickaccess .inner-toggle").css("padding-top"));
					                myaccountscroll.appendTo(jQuery("#ja-quickaccess .inner-toggle"));
					               
					                    setTimeout(function(){
					                    	  if(jQuery("#ja-quickaccess .inner-toggle").height() > windowheight){
					                    	  	myaccountscroll.css("height",windowheight);
					                            window.myaccountIScrol = new iScroll("myaccountscroll",{vScrollbar: true, useTransform: true,hScrollbar: false});
					                             window.myaccountIScrol.refresh();
					                          }

					                    },100);
					               
					    		   }
								    
							   		
						}

			    });
			    
	    }  


});

function updatemenuheight(object){
	 
		  mainavheight = (jQuery("#jm-megamenu ul.megamenu:first").height() < jQuery(window).height())?jQuery("#jm-megamenu ul.megamenu:first").height():jQuery(window).height()-120;
		  jQuery("#ja-mainnav-inner").height(mainavheight);										   
		  if(window.sidebarIScroll !== undefined && window.sidebarIScroll !== null){
			 window.sidebarIScroll.refresh();
		  }else{
			 window.sidebarIScroll = new iScroll('ja-mainnav-inner',{vScrollbar: true, useTransform: true,hScrollbar: true});   
		  }			
	
} 

//Add hover event for li - hack for IE6
function navMouseHover () {
	var lis = $$('#nav li');
	if (lis && lis.length) {
		lis.each (function(li){
			li.onMouseover = toggleMenu (li, 1);
			li.onMouseout = toggleMenu (li, 0);
		});
	}
}

toggleMenu = function (el, over) {
	  var iS = false;
    if (Element.childElements(el) && Element.childElements(el).length > 1) {
	    var uL = Element.childElements(el)[1];
			iS = true;
		}
    if (over) {
        Element.addClassName(el, 'over');
				Element.addClassName (el.down('a'), 'over');
        if(iS){ uL.addClassName('shown-sub')};
    }
    else {
        Element.removeClassName(el, 'over');
				Element.removeClassName (el.down('a'), 'over');
        if(iS){ uL.removeClassName('shown-sub')};
    }
}

jQuery(document).ready(function(){
	jQuery("#ja-mainnav .btn-toggle").attr("data-target","#jm-megamenu ul.level0");
	active = jQuery.cookie("jm_crafts_color");
	colorssetting = jQuery("div.colors-setting");
	if(active != undefined){
   	  colorssetting.find("a.colors-"+active).addClass("active");
	}

})
