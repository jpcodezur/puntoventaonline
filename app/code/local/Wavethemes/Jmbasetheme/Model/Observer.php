<?php

class Wavethemes_Jmbasetheme_Model_Observer
{
	/**
	 * Extend extra configs from etc folder of module on system init configs
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function extendConfig($observer)
	{
		$storeCode = Mage::helper("jmbasetheme")->getCurrentStoreCode("backend");
		$profiles = array_keys(Mage::helper("jmbasetheme")->getProfiles($storeCode));
		$mergeObject = new Mage_Core_Model_Config_Base();
		$profilePath =  Mage::helper("jmbasetheme")->getProfilePath($storeCode);
		foreach ($profiles as $profile) {
			if (file_exists($profilePath . "core" . DS . $profile . ".xml")) {
				$mergeObject->loadFile($profilePath . "core" . DS . $profile . ".xml");
			} else {
				$mergeObject->loadFile($profilePath . "local" . DS . $profile . ".xml");
			}
			$observer->config->extend($mergeObject, false);
		}

		if (file_exists($profilePath . "core" . DS . "core.xml")) {
			$mergeObject->loadFile($profilePath . "core" . DS . "core.xml");
			$observer->config->extend($mergeObject, false);
		}

		//extend tablet settings
		$mergeObject->loadFile(Mage::getModuleDir('etc', 'Wavethemes_Jmbasetheme') . "/device.xml");
		$observer->config->extend($mergeObject, false);

		//extend mobile settings
		$mergeObject->loadFile(Mage::getModuleDir('etc', 'Wavethemes_Jmbasetheme') . "/mobile.xml");
		$observer->config->extend($mergeObject, false);
	}


	/**
	 * Change content of body function
	 *
	 * @param string $response	The string content of body
	 */
	public function changeBody($response)
	{
		$body = $response["response"]->getBody();

		$css = array();
		$baseSkinUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);

		//Check switch color if has to set first priority
		$activeProfile = null;
		if(isset($_GET['jmcolor'])){
			$activeProfile = $_GET['jmcolor'];
		}else{
			$storeCode = Mage::helper("jmbasetheme")->getCurrentStoreCode();
		}

		if(!$activeProfile){
			//$activeProfile = Mage::getStoreConfig("wavethemes_jmbasetheme/jmbasethemegeneral/profile", $storeCode);
			$activeProfile = Mage::helper("jmbasetheme")->getProfileName($storeCode);
		}

		$css[] = '<link type="text/css" rel="stylesheet" href="' . $baseSkinUrl . 'frontend/base/default/wavethemes/jmbasetheme/css/settings.css.php?profile=' . $activeProfile . '" />';

		$activeCssFile = Mage::helper("jmbasetheme")->getSkinProfilePath($storeCode) . $activeProfile . DS . $activeProfile . ".css.php";

		if (file_exists($activeCssFile)) {
//			$profileContent = file_get_contents($activeCssFile);
//			if (!empty($profileContent)) {
//				Mage::helper("jmbasetheme")->writeTofile(trim($profileContent), $activeCssFile);
//			}

			$link = str_replace(Mage::getBaseDir("skin"), "", $activeCssFile);
			$link = str_replace(array("\\", "/frontend"), array("/", "frontend"), $link);
			$css[] = '<link type="text/css" rel="stylesheet" href="' . $baseSkinUrl . $link . '" />';
		}
		$body = str_ireplace("</head>", implode('', $css) . '</head>', $body);

		//Update body content
		$response["response"]->setBody($body);
	}

	/**
	 * Update the Toolbar content after layout generate blocks when on mobile mode.
	 *
	 * @param Varien_Event_Observer $observer
	 *
	 */
	public function resetToolbar($observer)
	{
		if (!Mage::app()->getStore()->isAdmin()) {
			$toolbar = $observer['layout']->getBlock("product_list_toolbar");
			$devicedetect = Mage::helper('jmbasetheme/mobiledetect');
			$baseconfig = Mage::helper("jmbasetheme")->getactiveprofile();
			if (Mage::registry('current_category') && $toolbar && $devicedetect->isMobile() && $baseconfig['quanlityperpage'] != "") {
				$toolbar->addPagerLimit("grid", $baseconfig["quanlityperpage"]);
				$toolbar->addPagerLimit("list", 8);
			}
		}
	}

	/**
	 * Merge configs after save config
	 * This was not use
	 */
//	public function saveProfile()
//	{
//		$storeCode = Mage::helper("jmbasetheme")->getCurrentStoreCode("backend");
//		$profile = Mage::getStoreConfig("wavethemes_jmbasetheme/jmbasethemegeneral/profile", $storeCode);
//		$settings = Mage::getStoreConfig("wavethemes_jmbasetheme", $storeCode);

//		if (is_array($settings["jmbasetheme" . $profile])) {
//			array_merge($settings["jmbasethemebase"], $settings["jmbasetheme" . $profile]);
//		}
	//var_dump($settings["jmbasethemebase"]);die();
	//Mage::helper("jmbasetheme")->saveProfile($profile.".ini", $settings["jmbasethemebase"], $storeCode);
//	}

}
	
	

