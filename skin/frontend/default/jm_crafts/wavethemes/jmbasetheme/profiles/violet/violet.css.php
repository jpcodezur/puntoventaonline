<?php
	$mageFilename = "../../../../../../../../app/Mage.php";
	require_once $mageFilename; 
	umask(0);
	Mage::app();
	$baseconfig = Mage::helper("jmbasetheme")->getactiveprofile();
	header("Content-type: text/css; charset: UTF-8");
?>

/* Base settings */
body#bd {
	background-image:url("images/<?php echo $baseconfig["bgimage"]; ?>");
}

#ja-header {
	background-image:url("images/<?php echo $baseconfig["headerimage"]; ?>");
	background-color: <?php echo $baseconfig["headerolor"] ?>;
}

#ja-botsl,
#ja-footer{
	background-image:url("images/<?php echo $baseconfig["footerimage"]; ?>");
	background-color: <?php echo $baseconfig["footerolor"] ?>;
}


h1#logo a  {
	background-image:url("images/<?php echo $baseconfig["logo"]; ?>") !important;
}
button.button, 
button,
#ja-tops2 .hot-products .inner,
button.button:hover, 
button.button:focus, 
button:hover, 
button:focus,
div.item-more h3,
a.btn-btt,
div#infscr-loading div,
#cboxTool #cboxPrevious:hover,
#cboxTool #cboxNext:hover,
#cboxTool #cboxClose:hover,
.pager .pages .current,
.pager .pages li a:active, 
.pager .pages li a:focus, 
.pager .pages li a:hover,
.checkout-progress li.active,
#ja-mycart .btn-toggle.mycart-toggle {
	background-color: <?php echo $baseconfig["color"] ?>;
}


a,
a:hover,
a:active,
a:focus,
.shop-access a, 
#ja-footer a,
#ja-pathway ul li,
.shop-access a:hover, 
.shop-access a:active, 
.shop-access a:focus,
#ja-botsl ul li a:active,
#ja-botsl ul li a:focus,
#ja-botsl ul li a:hover,
#narrow-by-list dd li a:active,
#narrow-by-list dd li a:focus,
#narrow-by-list dd li a:hover,
.products-list .product-shop h2 a:active, 
.products-list .product-shop h2 a:focus, 
.products-list .product-shop h2 a:hover,
.products-list .product-shop .price-box .price,
.jm-megamenu ul.level0 li.mega.active a.mega,
.product-essential .price-box .special-price .price,
.add-to-links a:active, 
.add-to-links a:focus, 
.add-to-links a:hover,
.regular-price .price,
#ja-mycart .summary a,
#ja-mycart .price,
#ja-mycart .product-name a:active, 
#ja-mycart .product-name a:focus, 
#ja-mycart .product-name a:hover,
#ja-mycart .summary .subtotal .price,
.data-table .cart-price,
.block-compare .actions a,
.cart-collaterals .totals .price,
.cart-table .product-name a:active, 
.cart-table .product-name a:focus, 
.cart-table .product-name a:hover,
.block-compare ol#compare-items li a:active, 
.block-compare ol#compare-items li a:focus, 
.block-compare ol#compare-items li a:hover,
.product-img-box .more-views  .icon-caret-left,
#ja-quicksetting .btn-toggle.quicksetting-toggle.active,
#ja-quickaccess .btn-toggle.quickaccess-toggle.active,
#my-orders-table .price,
.block-account li a:hover, 
.block-account li a:active, 
.block-account li a:focus,
.block-account li.current,
#login-form .buttons-set a,
#ja-botsl .block-location a,
.products-grid .price-box .price,
ul.ja-tab-navigator li.active a,
.products-grid h2 a:active, 
.products-grid h2 a:focus, 
.products-grid h2 a:hover, 
.products-grid h3 a:active, 
.products-grid h3 a:focus, 
.products-grid h3 a:hover, 
.products-grid h5 a:active, 
.products-grid h5 a:focus, 
.products-grid h5 a:hover,
.jm-megamenu ul.level0 li.mega a.mega:hover, 
.jm-megamenu ul.level0 li.mega:hover > a.mega,
#ja-mycart .btn-toggle.mycart-toggle:active,
#ja-mycart .btn-toggle.mycart-toggle:focus,
#ja-mycart .btn-toggle.mycart-toggle:hover,
#ja-mycart .btn-toggle.mycart-toggle.active,
.product-essential .availability.in-stock span,
.ratings .rating-links a:active,
.ratings .rating-links a:focus,
.ratings .rating-links a:hover,
#ja-quicksetting .btn-toggle.quicksetting-toggle:active, 
#ja-quicksetting .btn-toggle.quicksetting-toggle:focus, 
#ja-quicksetting .btn-toggle.quicksetting-toggle:hover,
#ja-quickaccess .btn-toggle.quickaccess-toggle:active, 
#ja-quickaccess .btn-toggle.quickaccess-toggle:focus,
#ja-quickaccess .btn-toggle.quickaccess-toggle:hover {
  color: <?php echo $baseconfig["color"] ?>;
}

.jm-megamenu ul.level1 ul.level2 li.mega.active a.mega,
.jm-megamenu ul.level1 ul.level2 li.mega a.mega:hover,
.jm-megamenu ul.level1 ul.level2 li.mega:hover > a.mega,
.jm-megamenu ul.level1 li.mega.active a.mega,
.jm-megamenu ul.level1 li.mega a.mega:hover,
.jm-megamenu ul.level1 li.mega:hover > a.mega {
	background-image:url("images/<?php echo $baseconfig["bullet"]; ?>")  !important;
	color: <?php echo $baseconfig["color"] ?> !important;
}

.data-table .btn-remove2:active, 
.data-table .btn-remove2:focus, 
.data-table .btn-remove2:hover,
.data-table .btn-remove2 {
	background-color: <?php echo $baseconfig["color"] ?> !important;
}

a.btn-btt:active, 
a.btn-btt:focus, 
a.btn-btt:hover {
	color: #fff;
}

.input-text:focus, 
select:focus, 
textarea:focus,
.form-currency a:active, 
.form-currency a:focus, 
.form-currency a:hover, 
.form-currency a.active,
.form-language a:active, 
.form-language a:focus, 
.form-language a:hover, 
.form-language a.active,
.colors-setting a:active, 
.colors-setting a:focus, 
.colors-setting a:hover,
.colors-setting a.active,
.pager .pages .current,
.product-img-box .more-views li a:hover {
	border-color: <?php echo $baseconfig["color"] ?>;
}

.add-to-links a.link-wishlist:active, 
.add-to-links a.link-wishlist:focus, 
.add-to-links a.link-wishlist:hover {
  background-image:url("images/<?php echo $baseconfig["wishlist"]; ?>");
}

div#infscr-loading .infscrloading {
  background-image:url("images/<?php echo $baseconfig["loadajax"]; ?>");
}

.add-to-links a.link-compare:active, 
.add-to-links a.link-compare:focus, 
.add-to-links a.link-compare:hover {
  background-image:url("images/<?php echo $baseconfig["compare"]; ?>");
}

.add-to-links a.email-friend:active, 
.add-to-links a.email-friend:focus, 
.add-to-links a.email-friend:hover {
  background-image:url("images/<?php echo $baseconfig["email"]; ?>");
}

.jm-megamenu  .products-grid .product-name a:hover{
	color: <?php echo $baseconfig["color"] ?>;
}