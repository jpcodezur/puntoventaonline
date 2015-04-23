<?php

class JoomlArt_JmProducts_ViewallController extends Mage_Core_Controller_Front_Action{
	
	public function IndexAction() {
		$this->loadLayout();

		$params = Mage::app()->getRequest()->getParams();

	    $block = $this->getLayout()->getBlock('viewall.jmproducts.list');
		if($block){
			//Take params from request
			foreach($params as $key => $value){
				$block->setData($key, $value);
			}
		}

        $this->renderLayout();
    }

}
