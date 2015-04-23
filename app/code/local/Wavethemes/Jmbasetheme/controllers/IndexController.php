<?php

class Wavethemes_Jmbasetheme_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->getLayout()->getBlock("head")->setTitle($this->__("Frontend basetheme"));
		$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		$breadcrumbs->addCrumb("home", array(
			"label" => $this->__("Home Page"),
			"title" => $this->__("Home Page"),
			"link" => Mage::getBaseUrl()
		));

		$breadcrumbs->addCrumb("frontend basetheme", array(
			"label" => $this->__("Frontend basetheme"),
			"title" => $this->__("Frontend basetheme")
		));

		$this->renderLayout();
	}

	public function createProfileAction()
	{
		$result = array();
		$requests = $this->getRequest()->getParams();
		$profilename = $requests["profile"];
		$settings = $requests["settings"];
		$storecode = isset($requests["storecode"]) ? $requests["storecode"] : null;
		if(!$storecode){
			$storecode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();
		}

		if (Mage::helper("jmbasetheme")->saveProfile($profilename . ".ini", $settings, $storecode)) {
			$result['message'] = $this->__("Profile %s was successfully created!", "<span class='profile-name'>".$profilename."</span>");
			$result['profile'] = $profilename;
			$result['settings'] = $settings;
			$result['type'] = "new";
			//clone the core profile's params

			//clone the profile's params
			$profilePath = Mage::helper("jmbasetheme")->getProfilePath($storecode);
			if (file_exists( $profilePath . "core" . DS . "core.xml")) {
				$xmlcontent = file_get_contents($profilePath . "core" . DS . "core.xml");
				$xmlcontent = str_replace("jmbasethemecore", "jmbasetheme" . $profilename, $xmlcontent);

				$xmlcontent = preg_replace("/settings\s*for\s*core\s*profile/", "settings for " . $profilename . " profile", $xmlcontent);

				if (!Mage::helper("jmbasetheme")->writeTofile($xmlcontent, $profilePath . "local" . DS . $profilename . ".xml")) {
					$result['error'] = "Could not save the " . $profilename . " profile settings !";
				}
			}
			//create new skin profile folder if it was not there
			$skinProfilePath = Mage::helper("jmbasetheme")->getSkinProfilePath($storecode);
			if (!is_dir($skinProfilePath . $profilename)) {
				mkdir($skinProfilePath . $profilename);
				chmod($skinProfilePath . $profilename, 0755);
			}

			//Clone the frontend css file from core
			if (file_exists($skinProfilePath . "core" . DS . "core" . ".css.php")) {
				$csscontent = trim(file_get_contents($skinProfilePath . "core" . DS . "core" . ".css.php"));
				Mage::helper("jmbasetheme")->writeTofile($csscontent, $skinProfilePath . $profilename . DS . $profilename . ".css.php");
				chmod($skinProfilePath . $profilename . DS . $profilename . ".css.php", 0755);
			}
			//clone the profile image folder
			if (is_dir($skinProfilePath . "core" . DS . "images")) {
				$src = $skinProfilePath . "core" . DS . "images";
				$dst = $skinProfilePath . $profilename . DS . "images";
				$this->rcopy($src, $dst);
			}
		} else {
			$result['error'] = $this->__("An error occurred while creating the profile!");
		}
		echo json_encode($result);
	}

	public function rcopy($src, $dst)
	{
		if (file_exists($dst)) rmdir($dst);
		if (is_dir($src)) {
			mkdir($dst);
			$files = scandir($src);
			foreach ($files as $file)
				if ($file != "." && $file != "..") $this->rcopy("$src/$file", "$dst/$file");
		} else if (file_exists($src)) copy($src, $dst);
	}

	public function cloneProfileAction()
	{
		$result = array();
		$requests = $this->getRequest()->getParams();
		$oldprofile = $requests["oldprofile"];
		$profilename = $requests["profile"];
		$settings = $requests["settings"];
		$storecode = isset($requests["storecode"]) ? $requests["storecode"] : null;
		if(!$storecode){
			$storecode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();
		}

		//clone the profile's params
		$profilePath = Mage::helper("jmbasetheme")->getProfilePath($storecode);
		if (file_exists( $profilePath . "core" . DS . $oldprofile . ".xml")) {
			$xmlcontent = file_get_contents($profilePath . "core" . DS . $oldprofile . ".xml");
			$xmlcontent = str_replace("jmbasetheme" . $oldprofile, "jmbasetheme" . $profilename, $xmlcontent);

			$xmlcontent = preg_replace("/settings\s*for\s*" . $oldprofile . "\s*profile/", "settings for " . $profilename . " profile", $xmlcontent);

			if (!Mage::helper("jmbasetheme")->writeTofile($xmlcontent, $profilePath . "local" . DS . $profilename . ".xml")) {
				$result['error'] = $this->__("Could not save the %s profile settings!", "<span class='profile-name'>".$profilename."</span>");
			}
		} else if (file_exists($profilePath . "local" . DS . $oldprofile . ".xml")) {
			$xmlcontent = file_get_contents($profilePath . "local" . DS . $oldprofile . ".xml");
			$xmlcontent = str_replace("jmbasetheme" . $oldprofile, "jmbasetheme" . $profilename, $xmlcontent);

			$xmlcontent = preg_replace("/settings\s*for\s*" . $oldprofile . "\s*profile/", "settings for " . $profilename . " profile", $xmlcontent);

			if (!Mage::helper("jmbasetheme")->writeTofile($xmlcontent, $profilePath . "local" . DS . $profilename . ".xml")) {
				$result['error'] = $this->__("Could not save the %s profile settings!", "<span class='profile-name'>".$profilename."</span>");
			}

		}
		//create new skin profile folder if it was not there
		$skinProfilePath = Mage::helper("jmbasetheme")->getSkinProfilePath($storecode);
		if (!is_dir( $skinProfilePath . $profilename)) {
			mkdir($skinProfilePath . $profilename);
		}

		//Clone the frontend css file $profile.css.php
		if (file_exists($skinProfilePath . $oldprofile . DS . $oldprofile . ".css.php")) {
			$csscontent = file_get_contents($skinProfilePath . $oldprofile . DS . $oldprofile . ".css.php");
			Mage::helper("jmbasetheme")->writeTofile($csscontent, $skinProfilePath . $profilename . DS . $profilename . ".css.php");
		}
		//clone the profile image folder
		if (is_dir($skinProfilePath . $oldprofile . DS . "images")) {
			$src = $skinProfilePath . $oldprofile . DS . "images";
			$dst = $skinProfilePath . $profilename . DS . "images";
			$this->rcopy($src, $dst);
		}

		//clone the setting values
		if (Mage::helper("jmbasetheme")->saveProfile($profilename . ".ini", $settings, $storecode)) {
			$result['message'] = $this->__("Profile %s was successfully cloned!", "<span class='profile-name'>".$profilename."</span>");
			$result['profile'] = $profilename;
			$result['oldprofile'] = $oldprofile;
			$result['settings'] = $settings;
			$result['type'] = "clone";
		} else {
			$result['error'] = $this->__("An error occurred while creating the profile!");
		}
		echo json_encode($result);
	}

	public function saveProfileAction()
	{
		$result = array();
		$requests = $this->getRequest()->getParams();
		$profilename = $requests["profile"];
		$settings = $requests["settings"];
		$storecode = isset($requests["storecode"]) ? $requests["storecode"] : null;
		if(!$storecode){
			$storecode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();
		}

		//check to see if this is a core profile
		$iscore = false;
		if (file_exists(Mage::helper("jmbasetheme")->getProfilePath($storecode) . "core" . DS . $profilename . ".ini")) {
			$iscore = true;
		}

		if (isset($settings["deleteimages"]) && $settings["deleteimages"] !== "") {
			$deleteimages = explode(",", $settings["deleteimages"]);
			foreach ($deleteimages as $image) {
				$skinProfilePath = Mage::helper("jmbasetheme")->getSkinProfilePath($storecode);
				$isDefaultImage = false;
				$delete = false;

				if (substr($image, 0, 7) == 'default') {
					$isDefaultImage = true;
				}
				if (!$iscore || ($iscore && !$isDefaultImage)){
					$delete = true;
				}

				if ($delete && file_exists($skinProfilePath . $profilename . DS . "images" . DS . $image)) {
					@unlink($skinProfilePath . $profilename . DS . "images" . DS . $image);
				}
			}
		}
		if (Mage::helper("jmbasetheme")->saveProfile($profilename . ".ini", $settings, $storecode)) {
			$result['message'] = $this->__("Profile %s was successfully saved! Please wait to saving the profile for current configuration scope.", "<span class='profile-name'>".$profilename."</span>");
			$result['profile'] = $profilename;
			$result['settings'] = $settings;
			$result['type'] = "saveProfile";
		} else {
			$result['error'] = $this->__("An error occurred while saving the profile!");
		}

		echo json_encode($result);
	}

	public function restoreProfileAction()
	{
		$result = array();
		$requests = $this->getRequest()->getParams();
		$profilename = $requests["profile"];
		$storecode = isset($requests["storecode"]) ? $requests["storecode"] : null;
		if(!$storecode){
			$storecode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();
		}

		if (file_exists(Mage::helper("jmbasetheme")->getProfilePath($storecode) . "core" . DS . $profilename . ".ini")) {
			$settings = parse_ini_file(Mage::helper("jmbasetheme")->getProfilePath($storecode) . "core" . DS . $profilename . ".ini");
			$settings["iscore"] = true;
			Mage::helper("jmbasetheme")->saveProfile($profilename . ".ini", $settings);
			$result['message'] = $this->__("Profile %s was successfully restored to default!", "<span class='profile-name'>".$profilename."</span>");
			$result['profile'] = $profilename;
			$result['settings'] = $settings;
			$result['type'] = "restore";
		} else {
			$result['error'] = $this->__("This is not a core profile so you can't restore it!");
		}

		echo json_encode($result);
	}

	public function deleteProfileAction()
	{
		$result = array();
		$requests = $this->getRequest()->getParams();
		$profilename = $requests["profile"];
		$storecode = isset($requests["storecode"]) ? $requests["storecode"] : null;
		if(!$storecode){
			$storecode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();
		}

		$profilePath = Mage::helper("jmbasetheme")->getProfilePath($storecode);
		//delete ini file
		if(file_exists($profilePath . "local" . DS . $profilename . ".ini")) {
			@unlink($profilePath . "local" . DS . $profilename . ".ini");

			//delete xml file
			if (file_exists($profilePath . "local" . DS . $profilename . ".xml")) {
				@unlink($profilePath . "local" . DS . $profilename . ".xml");
			}

			//Delete assets from skin profile
			$skinProfilePath = Mage::helper("jmbasetheme")->getSkinProfilePath($storecode);
			Mage::helper('jmbasetheme')->removeDir($skinProfilePath.$profilename);

			//reset profile to default
			Mage::getConfig()->saveConfig("wavethemes_jmbasetheme/jmbasethemegeneral/profile", "default");

			//built result
			$result['message'] = $this->__("Profile %s was successfully deleted!", "<span class='profile-name'>".$profilename."</span>");
			$result['profile'] = $profilename;
			$result['type'] = "delete";
		} else {
			$result['error'] = $this->__("The profile does not exists!");
		}

		echo json_encode($result);
	}

}