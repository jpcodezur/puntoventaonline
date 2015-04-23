
(function($){
    var defaults = {
    	columns:4,
    	itemSelector:'li.item',
    	viewmoretext:"Click To Load More Awesomeness...",
    	loadalltext:"'That\'s all we have for now :('",
    	callback:null	
    }
    var jminfinite = function(container,options){
      this.options = $.extend({}, defaults, options);
      this.options.container = container;
  	  this.initialize(); 
    }


    jminfinite.prototype = {
    	initialize:function(){
            var $container = this.options.container,itemSelector = this.options.itemSelector;
          
            if($('.next').attr('href')){
			  $('<div id="item-more" class="mitem item-more"><div class="inner item-inner clearfix"><h3><span>'+this.options.viewmoretext+'</span></h3></div></div>').appendTo ($container);
            }
		   //fix gap when custom font loaded
			$(window).load($.proxy(function(){
				
				   /* infinitive scroll for main masonry only */
				   if ($container.length) {
							var pathObject = {
								init: function(){
									    this.path = ($('.next').attr('href') || '');
									    this.lastpage = parseInt($('.lastpage:first').html());
										this.number = 1;
								},
								
								join: function(page){
									   this.number = parseInt(this.number) + 1;
									   if(this.number > this.lastpage) return null;
									   this.newpath = this.path.replace(/\?p=(\d+)/,"?p="+this.number);
									   return this.newpath;
								}
							};

							pathObject.init();
							$container.infinitescroll({
								navSelector  : '.pages',    // selector for the paged navigation 
								nextSelector : '.next',  // selector for the NEXT link (to page 2)
								itemSelector : itemSelector,     // selector for all items you'll retrieve
								extraScrollPx: 100,
								pathParse: pathObject,
								errorCallback: $.proxy(function(){
								$('#item-more .inner').unbind('click').find('h3:first').html(this.options.loadalltext).show();
							    },this),
								loading: {
				                    selector:'#item-more .item-inner',   
									finishedMsg: " ",
									msgText: "Loading",
									img: Baseurl+this.options.loadingimage,
								}
							}, $.proxy(function( newElements ) {
                                if(this.options.callback){
                                	this.options.callback(this,newElements);
                                }  								
								
							},this));
							$(window).unbind('.infscr');
						
							$('#item-more .inner').click(function(){
								$('h3:first', this).hide();
								$container.infinitescroll('retrieve');
							});
			
				    }
			},this)); 
    	}
    }

    $.fn.jminfinite = function(options){
			new jminfinite(this,options);
		
    };

})(jQuery)
