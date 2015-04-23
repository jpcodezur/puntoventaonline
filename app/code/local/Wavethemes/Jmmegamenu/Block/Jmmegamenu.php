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

class Wavethemes_Jmmegamenu_Block_Jmmegamenu extends Mage_Page_Block_Html_Topmenu
{
    protected $megaHelper = null;

	public function __construct($attributes = array())
	{
		parent::__construct();

        if (!Mage::helper('jmmegamenu')->get('show', $attributes)) {
            return true;
        }

		$this->addData(array(
			'cache_lifetime' => null,
		));

		$this->megaHelper = Mage::helper('jmmegamenu/megaClass');

        $params = array(
            'animation' => Mage::helper('jmmegamenu')->get('animation', $attributes),
            'addition_class' => ''
        );
        $params = array_merge($params, $attributes);

        $this->megaHelper->setParams($params);
	}

	protected function _toHtml()
	{
        //bind data vars if has
        $attributes = get_object_vars($this->megaHelper->params);
        foreach ( $attributes as $key => $value){
            $data = $this->getData($key);
            if ($data){
                $attributes[$key] = $data;
            }
        }
        $this->megaHelper->setParams($attributes);

		//set template
        $this->setTemplate("joomlart/jmmegamenu/output.phtml");

		//get menu id
        $menu_group_id = isset ($this->megaHelper->params->menu_group_id) ? $this->megaHelper->params->menu_group_id : null;
        $menu_key = isset ($this->megaHelper->params->menu_key) ? $this->megaHelper->params->menu_key : null;
        if(!$menu_group_id){
            $menu_group_id = Mage::helper('jmmegamenu')->getMenuId($menu_key);

            $this->megaHelper->setParams(array(
                'menu_group_id' => $menu_group_id
            ));
        }

		if($menu_group_id){

			//get menu items
			$collections = Mage::getModel('jmmegamenu/jmmegamenu')->getCollection()->setOrder("parent", "ASC")->setOrder("ordering", "ASC")->addFilter("status", 1, "eq")->addFilter("menugroup", $menu_group_id);

			//built menu tree
			$tree = array();
			foreach ($collections as $collection) {
				$collection->tree = array();
				$parent_tree = array();
				if (isset($tree[$collection->parent])) {
					$parent_tree = $tree[$collection->parent];
				}
				//Create tree
				array_push($parent_tree, $collection->menu_id);
				$tree[$collection->menu_id] = $parent_tree;

				$collection->tree = $parent_tree;
			}
			$this->megaHelper->getList($collections);

			ob_start();
			$this->megaHelper->genMenu();
			$output = ob_get_contents();
			$this->assign('menuoutput', $output);
			ob_end_clean();
		}
		else{
			echo Mage::helper('jmmegamenu')->__('There are not menu items found.');
		}

		return parent::_toHtml();
	}

}
