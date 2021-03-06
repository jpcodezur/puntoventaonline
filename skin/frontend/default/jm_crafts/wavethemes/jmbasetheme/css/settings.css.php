<?php

 $mageFilename = "../../../../../../../app/Mage.php";
 require_once $mageFilename; 
 umask(0);
 Mage::app();
 $profile = $_GET["profile"];
 
 if($profile = $_GET["profile"]){
     $activeprofile = $profile;
 }else{
     $activeprofile = Mage::helper("jmbasetheme")->getprofile();
 }
 
 $defaultheme = Mage::helper("jmbasetheme")->gettheme();
 $baseconfig = Mage::helper("jmbasetheme")->getactiveprofile($activeprofile);
 header("Content-type: text/css; charset: UTF-8");
?>

/* Base settings */
body#bd {
   background-color: <?php echo $baseconfig["bgolor"]; ?>;
   background-image:url("../../../../<?php echo $defaultheme; ?>/wavethemes/jmbasetheme/profiles/<?php echo $activeprofile ?>/images/<?php echo $baseconfig["bgimage"]; ?>");
}

@media only screen and (min-width:986px) and (max-width: 1235px) {
	.product-img-box .product-image-zoom {
		width: <?php echo $baseconfig["productlimagewidthtablet"]; ?>px;
		height: <?php echo $baseconfig["productlimageheighttablet"]; ?>px;
	}
    .product-view p.product-image img{
     width:<?php echo $baseconfig["productlimagewidthtablet"]; ?>px;
     height:<?php echo $baseconfig["productlimageheighttablet"]; ?>px;
    }
}

/* Grid product list tablet portrait settings */
@media only screen and (min-width:720px) and (max-width: 985px){
   .category-products .products-grid li.item {
      width: <?php echo 100/$baseconfig["productgridnumbercolumntabletportrait"]."%" ?> !important;
   }
   
   .category-products .products-grid .product-image img {
	   width:<?php echo $baseconfig["productgridimagewidthtabletportrait"]; ?>px;
	   height:<?php echo $baseconfig["productgridimageheighttabletportrait"]; ?>px;
    }
    .category-products .products-list .product-image img {
	   width:<?php echo $baseconfig["productlistimagewidthtabletportrait"]; ?>px;
	   height:<?php echo $baseconfig["productlistimageheighttabletportrait"]; ?>px;
    }
	.product-img-box .product-image-zoom {
		width: <?php echo $baseconfig["productlimagewidthtabletportrait"]; ?>px;
		height: <?php echo $baseconfig["productlimageheighttabletportrait"]; ?>px;
	}
    .product-view p.product-image img{
     width:<?php echo $baseconfig["productlimagewidthtabletportrait"]; ?>px;
     height:<?php echo $baseconfig["productlimageheighttabletportrait"]; ?>px;
    }

}

@media only screen and (max-width:719px){
	.product-img-box .product-image-zoom {
		width: <?php echo $baseconfig["productlimagewidthmobile"]; ?>px;
		height: <?php echo $baseconfig["productlimagewidthmobile"]; ?>px;
	}
    .product-view p.product-image img{
     width:<?php echo $baseconfig["productlimagewidthmobile"]; ?>px;
     height:<?php echo $baseconfig["productlimagewidthmobile"]; ?>px;
    }
}
@media only screen and (max-width:479px){
   .category-products .products-grid li.item {
      width: <?php echo 100/$baseconfig["productgridnumbercolumnmobileportrait"]."%" ?> !important;
   }
   .category-products .products-grid .product-image img {
	  width:<?php echo $baseconfig["productgridimagewidthmobileportrait"]; ?>px;
	  height:<?php echo $baseconfig["productgridimageheightmobileportrait"]; ?>px;
    }
	.product-img-box .product-image-zoom {
		width: <?php echo $baseconfig["productlimagewidthmobileportrait"]; ?>px;
		height: <?php echo $baseconfig["productlimagewidthmobileportrait"]; ?>px;
	}
    .product-view p.product-image img{
     width:<?php echo $baseconfig["productlimagewidthmobileportrait"]; ?>px;
     height:<?php echo $baseconfig["productlimagewidthmobileportrait"]; ?>px;
    }
}