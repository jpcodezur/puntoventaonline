<?php

class Wavethemes_Jmbasetheme_Model_Config_Profile
{

	public function toOptionArray()
	{
		$currentStoreCode = Mage::app()->getRequest()->getParam('store');
		if(!$currentStoreCode)
			$currentStoreCode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();

		$profiles = Mage::helper("jmbasetheme")->getProfiles($currentStoreCode);

		$profiles = array_keys($profiles);
		$options = array();
		foreach ($profiles as $f) {
			$options[] = array(
				'value' => $f,
				'label' => $f,
			);
		}

		return $options;
	}

}
