<?php

class JoomlArt_JmSlideshow_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Ajax list images from folder path action
     */
    public function listImagesAction()
    {
        if( Mage::app()->getRequest()->isAjax() ){
            $block = $this->getLayout()->createBlock('core/template', 'jmslideshow.listImages');
            if($block){
                $block->setTemplate('jmslideshow/listImages.phtml');

                $source = Mage::app()->getRequest()->getParam('source', 'images');
                $folderPath = Mage::app()->getRequest()->getParam('folder_path');

                //Get Images from folder
                $helper = Mage::helper('joomlart_jmslideshow/data');

                $configs = array();
                foreach($helper::$_params as $paramKey){
                    $configs[$paramKey] = $helper->get($paramKey);
                }
                $configs['folder'] = $folderPath;
                $configs['source'] = $source;
                $slides = $helper->getSlideShowData($configs);

                $block->setData('slides', $slides);

                echo $block->toHtml();
            }
        }
    }
}