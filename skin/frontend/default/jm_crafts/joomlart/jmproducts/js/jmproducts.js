// JavaScript Document
(function($){

   var defaults  = {
   	   productsgrid:{},
   	   istable:0,
       widthportrait:0,
       heightportrait:0,
   	   ismobile:0,
   } 

   var jmproduct = function(options){
      this.elm = options.productsgrid;
      this.options = $.extend({}, defaults, options);
  	  this.initialize(); 
   }
   jmproduct.prototype = {

      initialize:function(){
       
         if(this.options.istable){   
             $(window).resize($.proxy(function(){
              if($(window).width() < 780){
                  this.elm.find("li.item").css("width",100/this.options.perrowportrait+"%");
              	 
              }else{
                  this.elm.find("li.item").css("width",100/this.options.perrow+"%");
                  
              }   
             },this))
         }

         if(this.options.ismobile){
            $(window).resize($.proxy(function(){
              if($(window).width() < 361){
                  this.elm.find("li.item").css("width",100/this.options.perrowportrait+"%");
                 
              }else{
                  this.elm.find("li.item").css("width",100/this.options.perrow+"%");
             
              }
            },this))
         }
         this.reloadtab(); 
      },

      reloadtab:function(){
         if($("ul.jm-tabs-title li.active")){
            $("ul.jm-tabs-title li.active").trigger("click");
         }
      }


   }
   $.fn.jmproduct = function(options){
     
      options.productsgrid = $(this);
   	  opotions = $.extend({},options);
    	new jmproduct(options);
		
   };

})(jQuery);

