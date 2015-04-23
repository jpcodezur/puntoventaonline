<?php

class JoomlArt_JmProducts_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function AjaxLoadMoreAction() {
		if( Mage::app()->getRequest()->isAjax() ){
			$params = Mage::app()->getRequest()->getParams();
			$block = $this->getLayout()->createBlock('joomlart_jmproducts/list', 'jmproducts.index.ajaxloadmore'.microtime());
			if($block){
				//Take params from request
				foreach($params as $key => $value){
					if($key != 'template'){
						$block->setData($key, $value);
					}
				}

				echo $block->setTemplate('joomlart/jmproducts/list_ajax_more.phtml')->toHtml();
			}

		}
		die();
    }

}
