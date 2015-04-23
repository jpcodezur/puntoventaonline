<?php

/*------------------------------------------------------------------------
# $JA#PRODUCT_NAME$ - Version $JA#VERSION$ - Licence Owner $JA#OWNER$
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites: http://www.joomlart.com - http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
-------------------------------------------------------------------------*/

class JoomlArt_JmProducts_Block_List extends Mage_Catalog_Block_Product_Abstract
{
	public $_config = array();
	protected $_defaultToolbarBlock = 'catalog/product_list_toolbar';

	public function __construct($attributes = array())
	{
		$helper = Mage::helper('joomlart_jmproducts/data');
		$detect = Mage::helper('joomlart_jmproducts/mobiledetect');

		//Handle configs value from configs or static block call line
		$this->_config['show'] = $helper->get('show', $attributes);
		if (!$this->_config['show'])
			return;

		$this->_config['template'] = $helper->get('template', $attributes);

		parent::__construct();

		$this->_config['mode'] = $helper->get('mode', $attributes);

		$this->_config['title'] = $helper->get('headtitle', $attributes);

		$this->_config['page'] = 1;

		$this->_config['catsid'] = $helper->get('catsid', $attributes);
		$this->_config['category_ids'] = $helper->get('category_ids', $attributes);

		$this->_config['productsid'] = $helper->get('productsid', $attributes);

		$this->_config['qty'] = $helper->get('quanlity', $attributes);

		$this->_config['qtytable'] = $helper->get('quanlitytable', $attributes);

		$this->_config['qtytableportrait'] = $helper->get('quanlitytableportrait', $attributes);

		$this->_config['qtymobile'] = $helper->get('quanlitymobile', $attributes);
        if(!$this->_config['qtymobile'])
            $this->_config['qtymobile'] = 2;

		$this->_config['qtymobileportrait'] = $helper->get('quanlitymobileportrait', $attributes);
        if(!$this->_config['qtymobileportrait'])
            $this->_config['qtymobileportrait'] = 2;

		$this->_config['qtyperpage'] = $helper->get('quanlityperpage', $attributes);
		if(!$this->_config['qtyperpage'])
			$this->_config['qtyperpage'] = 10;

		$this->_config['qtyperpagetable'] = $helper->get('quanlityperpagetable', $attributes);
		if(!$this->_config['qtyperpagetable'])
			$this->_config['qtyperpagetable'] = 4;

		$this->_config['qtyperpagemobile'] = $helper->get('quanlityperpagemobile', $attributes);
		if(!$this->_config['qtyperpagemobile'])
			$this->_config['qtyperpagemobile'] = 2;

		$this->_config['istable'] = 0;
		$this->_config['ismobile'] = 0;

		$this->_config['perrow'] = $helper->get('perrow', $attributes);
		$this->_config['perrowtablet'] = $helper->get('perrowtablet', $attributes);
		$this->_config['perrowtabletportrait'] = $helper->get('perrowtabletportrait', $attributes);
		$this->_config['perrowmobile'] = $helper->get('perrowmobile', $attributes);
		$this->_config['perrowmobileportrait'] = $helper->get('perrowmobileportrait', $attributes);

		$this->_config['ajaxloadmore'] = $helper->get('ajaxloadmore', $attributes);
		$this->_config['ajaxloadmoremobile'] = $helper->get('ajaxloadmoremobile', $attributes);
		$this->_config['ajaxloadmoretable'] = $helper->get('ajaxloadmoretable', $attributes);
		$this->_config['accordionslider'] = $helper->get('accordionslider', $attributes);

		$this->_config['width'] = $helper->get('width', $attributes);
		$this->_config['height'] = $helper->get('height', $attributes);
		$this->_config['max'] = $helper->get('max', $attributes);
		$this->_config['random'] = $helper->get('random', $attributes);

		if ($detect->isTablet()) {
			$this->_config['istable'] = 1;
			$this->_config['qty'] = $this->_config['qtytable'];
			$this->_config['qtyperpage'] = $this->_config['qtyperpagetable'];
			$this->_config['perrow'] = $this->_config['perrowtablet'];
			$this->_config['ajaxloadmore'] = $this->_config['ajaxloadmoretable'];
			$this->_config['accordionslider'] = 0;

		} elseif ($detect->isMobile()) {
			$this->_config['ismobile'] = 1;
			$this->_config['qty'] = $this->_config['qtymobile'];
			$this->_config['qtyperpage'] = $this->_config['qtyperpagemobile'];
			$this->_config['perrow'] = $this->_config['perrowmobile'];
			$this->_config['ajaxloadmore'] = $this->_config['ajaxloadmoremobile'];
			$this->_config['accordionslider'] = 0;
		}

	}

//	public function _prepareLayout()
//	{
//		$headBlock = $this->getLayout()->getBlock('head');
//		if($headBlock){
//			//Do some thing to add assets here...
//			if($this->_config['accordionslider']){
//				$headBlock->addItem('skin', 'joomlart/jmproducts/css/jmproduct_accordion.css');
//			}
//		}

//		return parent::_prepareLayout();
//	}

	protected function _beforeToHtml()
	{
		if (!$this->_config['show'])
			return;

		//Handle data from call line in xml (custom design)
		foreach ($this->_config as $key => $value){
			$data = $this->getData($key);
			if ($data){
				$this->_config[$key] = $data;

				//if has template input from call line. This only use for old theme.
				if($key == 'template'){
					$this->setTemplate($data);
				}
			}
		}

        // This for old theme
        if (!$this->_config['category_ids'] AND $this->_config['catsid']){
            $this->_config['category_ids'] = $this->_config['catsid'];
        }

		if($this->_config["ajaxloadmore"]){
			$this->_config["accordionslider"] = 0;
		}

		if($this->_config["accordionslider"]){
			$this->_config["ajaxloadmore"] = 0;
		}

		//get product collection
		$collection = $this->getProductCollection();

        $tmpl = $this->getTemplate();
        if($tmpl == "joomlart/jmproducts/list.phtml" || $tmpl == 'joomlart/jmproducts/viewall.phtml')// This only use for normal list
		{
			$toolbar = $this->getToolbarBlock();

			// use sortable parameters
			if ($orders = $this->getAvailableOrders()) {
				$toolbar->setAvailableOrders($orders);
			}
			if ($sort = $this->getSortBy()) {
				$toolbar->setDefaultOrder($sort);
			}
			if ($dir = $this->getDefaultDirection()) {
				$toolbar->setDefaultDirection($dir);
			}
			if ($modes = $this->getModes()) {
				$toolbar->setModes($modes);
			}

			$toolbar->addPagerLimit("grid", $this->_config['qtyperpage']);
			$toolbar->addPagerLimit("list", $this->_config['qtyperpage']);

			// set collection to toolbar and apply sort
			if (is_object($collection))
			{
				$toolbar->setCollection($collection);
				$this->setChild('toolbar', $toolbar);
				Mage::dispatchEvent('catalog_block_product_list_collection', array(
					'collection' => $collection
				));
			}
		}

		return parent::_beforeToHtml();
	}

	public function _toHtml()
	{
		if (!$this->_config['show'])
			return;

		//set template if not set
		if (!$this->getTemplate()) {
			$tmpl = 'joomlart/jmproducts/list.phtml';

			if($this->_config['ajaxloadmore']){
				if($this->_config['page'] == 1){ //for first entry
					$tmpl = 'joomlart/jmproducts/list_ajax.phtml';
				}
			}else if($this->_config['accordionslider']){
				$tmpl = 'joomlart/jmproducts/list_accordion.phtml';
			}

			$this->setTemplate($tmpl);
		}
		//echo $this->getTemplate();die();
		//append product review summary
		if ($this->getCollection()) {
			Mage::getModel('review/review')->appendSummary($this->getCollection());
		}

		//assign data to template
		$this->assign('listall', $this->getCollection());
		$this->assign('listall2', $this->getCollection()); // This only for old theme (jm_gamestore theme...)
		$this->assign('config', $this->_config);

		return parent::_toHtml();
	}

	public function getProductCollection()
	{
		$collection = null;
		if(!$this->getCollection())
		{
			$helper = Mage::helper('joomlart_jmproducts/data');

			$collection = $helper->getProductCollection($this->_config);

			//set collection
			$this->setCollection($collection);
		}

		return $collection;
	}

	public function getTotalRecords(){
		$helper = Mage::helper('joomlart_jmproducts/data');
		$this->_config['get_total'] = true;
		$collection = $helper->getProductCollection($this->_config);

		return $collection->count();
	}

	public function getTotalPage(){
		$total = $this->getTotalRecords();
		return ceil($total / $this->_config['qtyperpage']);
	}

	/**
	 * Retrieve Toolbar block
	 *
	 * @return Mage_Catalog_Block_Product_List_Toolbar
	 */
	public function getToolbarBlock()
	{
		if ($blockName = $this->getToolbarBlockName()) {
			if ($block = $this->getLayout()->getBlock($blockName)) {
				return $block;
			}
		}
		$block = $this->getLayout()->createBlock($this->_defaultToolbarBlock, microtime());

		return $block;
	}

	/**
	 * Retrieve current view mode
	 *
	 * @return string
	 */
	public function getMode()
	{
		return $this->getChild('toolbar')->getCurrentMode();
	}

	/**
	 * Retrieve list toolbar HTML
	 *
	 * @return string
	 */
	public function getToolbarHtml()
	{
		return $this->getChildHtml('toolbar');
	}

	public function getFirstCategoryName($_product)
	{
		$root_cate_id = Mage::app()->getStore()->getRootCategoryId();
		$ids = $_product->getCategoryIds();
        $category_id = null;

		if ((count($ids) > 1) && ($ids[0] == $root_cate_id)) {
            if(isset($ids[1]))
			    $category_id = $ids[1];
		} else {
            if(isset($ids[0]))
			    $category_id = $ids[0];
		}

        $cate = Mage::getModel('catalog/category')->load($category_id);

		return $cate->getName();
	}

	public function getConfigs(){
		return $this->_config;
	}
}