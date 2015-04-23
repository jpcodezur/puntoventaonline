
#Quick guide

#Call block example
<block type="joomlart_jmslideshow/list" name="jm.slideshow1">
	<action method="addData"><data><title>1 - JM Slideshow With Horizontal Slide</title></data></action>
	<action method="addData"><data><thumbDirection>horizontal</thumbDirection></data></action>
	<action method="addData"><data><animation>hrzslide</animation></data></action>
	<action method="addData"><data><source>images</source></data></action>
	<action method="addData"><data><folder>media/jmslideshow</folder></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow2">
	<action method="addData"><data><title>2 - JM Slideshow With Vertical Slide (Data From Best Buy Products)</title></data></action>
	<action method="addData"><data><thumbDirection>vertical</thumbDirection></data></action>
	<action method="addData"><data><animation>vrtslide</animation></data></action>
	<action method="addData"><data><source>products</source></data></action>
	<action method="addData"><data><sourceProductsMode>best_buy</sourceProductsMode></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow3">
	<action method="addData"><data><title>3 - JM Slideshow With Fade Slide (Data From Latest Products)</title></data></action>
	<action method="addData"><data><thumbDirection>horizontal</thumbDirection></data></action>
	<action method="addData"><data><animation>fade</animation></data></action>
	<action method="addData"><data><source>products</source></data></action>
	<action method="addData"><data><sourceProductsMode>latest</sourceProductsMode></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow4">
	<action method="addData"><data><title>4 - JM Slideshow With Random Animation</title></data></action>
	<action method="addData"><data><animation>slice</animation></data></action>
	<action method="addData"><data><thumbDirection>horizontal</thumbDirection></data></action>
	<action method="addData"><data><source>images</source></data></action>
	<action method="addData"><data><folder>media/jmslideshow</folder></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow6">
	<action method="addData"><data><title>6 - JM Slideshow With Categories List</title></data></action>
	<action method="addData"><data><animation>hrzslide</animation></data></action>
	<action method="addData"><data><thumbDirection>horizontal</thumbDirection></data></action>
	<action method="addData"><data><source>categories</source></data></action>
	<action method="addData"><data><category_ids>4,5,6</category_ids></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow5">
	<action method="addData"><data><title>5 - JM Horizontal Accordion</title></data></action>
	<action method="addData"><data><animation>hrzaccordion</animation></data></action>
	<action method="addData"><data><source>images</source></data></action>
	<action method="addData"><data><folder>media/jmslideshow</folder></data></action>
</block>

<block type="joomlart_jmslideshow/list" name="jm.slideshow6">
	<action method="addData"><data><title>6 - JM Vertical Accordion (Data from categories)</title></data></action>
	<action method="addData"><data><animation>vrtaccordion</animation></data></action>
	<action method="addData"><data><source>categories</source></data></action>
	<action method="addData"><data><category_ids>4,5,6</category_ids></data></action>
</block>

//Params:
$arrayParams = array(
	'show', 						//[0,1]
	'title', 						//JM Slidehsow
	'loadjquery' ,					//[0,1]
	'source',						//[images,products,categories]
	'sourceProductsMode',			//[latest, best_buy, most_viewed, most_reviewed, top_rated, attribute]
	'catsid',						//4,5,6
	'quanlity',						//5
	'folder',						//media/jmslideshow
	'readMoreText', 
	
	'animation', 					//[slide, fade, slice, fullslide, hrzslide,vrtslide, hrzaccordion, vrtaccordion], slide and fade for old compactible
	
	'mainWidth',					//width of main item
	'mainWidthtablet',				//width of main item on tablet
	'mainWidthtabletportrait',
	'mainWidthmobile',
	'mainWidthmobileportrait',
	'mainHeight',					//height of main item
	
	'duration',						//[3000] (duration - time for animation (ms))
	
	'autoPlay',						//[0,1] auto play
	'repeat',						//[0,1] animation repeat or not
	'interval',						//[5000] interval - time for between animation	

	'thumbType', 					//['', number, thumb]false - no thumb, other, thumb will animate
	'thumbImgMode',					// [resize, crop]
	'useRatio',						// [0, 1]
	'thumbImgWidth',				//[80]
	'thumbImgHeight',				// [80]
	
	'thumbItems',					//[5]number of thumb item will be show
	'thumbWidth',					//[80] width of thumbnail item
	'thumbHeight',					//[80] width of thumbnail item
	'thumbSpaces',					//[5:5:5:5] space between thumbnails
	'thumbDirection',				//[horizontal, vertical]thumb orientation
	'thumbPosition',				//[top, right, bottom, left, tl, tr, bl, br]
	'thumbTrigger',					//[click, mouseenter] thumb trigger event, 
	'show_thumb_desc',				//[0,1] show thumbnail description or not
	'thumb_description',            // thumbnail description
	
	'controlBox',					//show navigation controller [next, prev, play, playback] - JM does not have a config
	'controlPosition',				//show navigation controller [next, prev, play, playback] - JM does not have a config
	
	'navButtons',					//main next/prev navigation buttons mode, [false, auto, fillspace]
	
	'showDesc',						//[desc, desc-readmore] show description or not
	'descMaxLength'					// [60] Max length of description
	'descTrigger',					//[always, mouseenter]
	'maskWidth',					//[400] mask - a div over the the main item - used to hold descriptions (px)
	'maskHeight',					//[150] mask height (px)
	'maskAnim',						//mask transition style ['', fade,vrtslide, hrzslide, hrzslidefade, vrtslidefade], slide - will use the maskAlign to slide
	'maskOpacity',					//mask opacity
	'maskPosition',					//[top, right, bottom, left, tl, tr, bl, br]
	'description',

	'showProgress',					//[0,1]show the progress bar
);







#Shortcode example for desc 

[desc img="1.jpg" url="http://joomlart.com" target="_blank"]
<div class="desc-slide">
<span class="text-title">What is Lorem Ipsum?</span>
<span class="text-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </span>
</div>
[/desc] 

[desc img="2.jpg" url="http://facebook.com" target="_blank"]
<div class="desc-slide">
<span class="text-title">Slide 2</span>
<span class="text-description">Description of slide 2</span>
</div>
[/desc] 

[desc img="3.jpg" url="#"]
<div class="desc-slide">
<span class="text-title">Slide 3</span>
<span class="text-description">Description of slide 3</span>
</div>
[/desc] 

[desc img="4.jpg" url="#"]
<div class="desc-slide">
<span class="text-title">Slide 4</span>
<span class="text-description">Description of slide 4</span>
</div>
[/desc] 

[desc img="5.jpg" url="#"]
<div class="desc-slide">
<span class="text-title">Slide 5</span>
<span class="text-description">Description of slide 5</span>
</div>
[/desc] 