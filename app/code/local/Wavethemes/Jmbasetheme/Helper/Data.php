<?php

class Wavethemes_Jmbasetheme_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $defaultStoreCode = null;
	protected $activeStoreCode = null;
	protected $cookieExp = null;

	public function __construct()
	{
		//set cookie expire
		$this->cookieExp = time() + 60 * 60 * 24 * 355; // one year

		//initial default store code
		$this->defaultStoreCode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();

		//initial current active store code
		if(isset($_GET["___store"]))
		{
			$this->activeStoreCode = $_GET["___store"];
			//Set cookie for later
			setcookie("active_store", $this->activeStoreCode, $this->cookieExp, "/");
		}
		else if(isset($_COOKIE["active_store"]))
		{
			$this->activeStoreCode = $_COOKIE["active_store"];
		}

		//set active color if has from request
		if(isset($_GET['jmcolor'])){
			//Set cookie for later
			setcookie($this->getDefaultTheme()."_active_color", $_GET['jmcolor'], $this->cookieExp, "/");
		}

	}

	public function getSkinPath($storeCode = null)
	{
		if(!$storeCode)
			$storeCode = $this->getCurrentStoreCode();

		$designPackage = $this->getDesignPackage($storeCode);
		$defaultTheme = $this->getDefaultTheme($storeCode);
		
		$skinPath = Mage::getBaseDir("skin") . DS . "frontend" . DS . $designPackage . DS . $defaultTheme;

		if (!is_dir($skinPath . DS . "wavethemes")) {
			mkdir($skinPath . DS . "wavethemes");
			chmod($skinPath . DS . "wavethemes", 0775);
			mkdir($skinPath . DS . "wavethemes" . DS . "jmbasetheme");
			chmod($skinPath . DS . "wavethemes" . DS . "jmbasetheme", 0775);
		}
		$skinPath = $skinPath . DS . "wavethemes" . DS . "jmbasetheme";

		return $skinPath;
	}

	public function getCssPath($storeCode = null)
	{
		$skinPath = $this->getSkinPath($storeCode);
		$cssPath = $skinPath . DS . "css" . DS;
		if (!is_dir($cssPath)) {
			mkdir($cssPath);
			chmod($cssPath, 0775);
		}

		return $cssPath;
	}

	public function getSkinProfilePath($storeCode = null)
	{
		$skinPath = $this->getSkinPath($storeCode);
		$skinProfilePath = $skinPath . DS . "profiles" . DS;
		if (!is_dir($skinProfilePath)) {
			mkdir($skinProfilePath);
			chmod($skinProfilePath, 0775);
		}

		return $skinProfilePath;
	}

	public function getDesignPath($storeCode = null)
	{
		$designPackage = $this->getDesignPackage($storeCode);
		$defaultTheme = $this->getDefaultTheme($storeCode);
		$designPath = Mage::getBaseDir("design") . DS . "frontend" . DS . $designPackage . DS . $defaultTheme;

		return $designPath;
	}

	public function getProfilePath($storeCode = null)
	{
		$designPath = $this->getDesignPath($storeCode);

		if (!is_dir($designPath . DS . "profiles")) {
			mkdir($designPath . DS . "profiles");
			chmod($designPath . DS . "profiles", 0775);
		}
		if (is_dir($designPath . DS . "profiles") && !is_dir($designPath . DS . "profiles" . DS . "core")) {
			mkdir($designPath . DS . "profiles" . DS . "core");
			chmod($designPath . DS . "profiles" . DS . "core", 0775);
		}
		if (is_dir($designPath . DS . "profiles") && !is_dir($designPath . DS . "profiles" . DS . "local")) {
			mkdir($designPath . DS . "profiles" . DS . "local");
			chmod($designPath . DS . "profiles" . DS . "local", 0775);
		}
		$profilePath = $designPath . DS . "profiles" . DS;

		return $profilePath;
	}

	public function getProfileContent(){

		$storeCode = $this->getCurrentStoreCode();

		$profileName = $this->getProfileName($storeCode);

		$profilePath = $this->getProfilePath($storeCode);

		if (file_exists($profilePath . "local" . DS . $profileName . ".ini")) {
			$configs = parse_ini_file($profilePath . "local" . DS . $profileName . ".ini");
		} else {
			$configs = parse_ini_file($profilePath . "core" . DS . $profileName . ".ini");
		}

		//Get the correct device fields
		$device = Mage::helper('jmbasetheme/mobiledetect');
		if ($device->isTablet()) {
			$configs["productlistdeslenght"] = isset($configs["productlistdeslenghttablet"]) && $configs["productlistdeslenghttablet"] ? $configs["productlistdeslenghttablet"] : $configs["productlistdeslenght"];
			$configs["showlabel"] = isset($configs["showlabeltablet"]) && $configs["showlabeltablet"] ? $configs["showlabeltablet"] : $configs["showlabel"];
			$configs["productgridnumbercolumn"] = isset($configs["productgridnumbercolumntablet"]) && $configs["productgridnumbercolumntablet"] ? $configs["productgridnumbercolumntablet"] : $configs["productgridnumbercolumn"];
			$configs["quanlityperpage"] = isset($configs["quanlityperpagetablet"]) && $configs["quanlityperpagetablet"] ? $configs["quanlityperpagetablet"] : "";
			$configs["productlimageheight"] = isset($configs["productlimageheighttablet"]) && $configs["productlimageheighttablet"] ? $configs["productlimageheighttablet"] : $configs["productlimageheight"];
			$configs["productlimageheightportrait"] = isset($configs["productlimageheighttabletportrait"]) && $configs["productlimageheighttabletportrait"] ? $configs["productlimageheighttabletportrait"] : $configs["productlimageheight"];
			if ($configs["productlimageheightportrait"] > $configs["productlimageheight"]) $configs["productlimageheight"] = $configs["productlimageheightportrait"];
			$configs["productlimagewidth"] = isset($configs["productlimagewidthtablet"]) && $configs["productlimagewidthtablet"] ? $configs["productlimagewidthtablet"] : $configs["productlimagewidth"];
			$configs["productlimagewidthportrait"] = isset($configs["productlimagewidthtabletportrait"]) && $configs["productlimagewidthtabletportrait"] ? $configs["productlimagewidthtabletportrait"] : $configs["productlimagewidth"];
			if ($configs["productlimagewidthportrait"] > $configs["productlimagewidth"]) $configs["productlimagewidth"] = $configs["productlimagewidthportrait"];

		} else if ($device->isMobile()) {
			$configs["productlistdeslenght"] = isset($configs["productlistdeslenghttmobile"]) && $configs["productlistdeslenghttmobile"] ? $configs["productlistdeslenghtmobile"] : $configs["productlistdeslenght"];
			$configs["showlabel"] = isset($configs["showlabelmobile"]) && $configs["showlabelmobile"] ? $configs["showlabelmobile"] : $configs["showlabel"];
			$configs["productgridnumbercolumn"] = isset($configs["productgridnumbercolumnmobile"]) && $configs["productgridnumbercolumnmobile"] ? $configs["productgridnumbercolumnmobile"] : $configs["productgridnumbercolumn"];
			$configs["quanlityperpage"] = isset($configs["quanlityperpagemobile"]) && $configs["quanlityperpagemobile"] ? $configs["quanlityperpagemobile"] : "";
			$configs["productlimageheight"] = isset($configs["productlimageheightmobile"]) && $configs["productlimageheightmobile"] ? $configs["productlimageheightmobile"] : $configs["productlimageheight"];
			$configs["productlimagewidth"] = isset($configs["productlimagewidthmobile"]) && $configs["productlimagewidthmobile"] ? $configs["productlimagewidthmobile"] : $configs["productlimagewidth"];
		}

		return $configs;
	}

	//This function for old themes & extensions
	public function getactiveprofile()
	{
		return $this->getProfileContent();
	}

	public function getDefaultTheme($storeCode = null, $location = "frontend")
	{
		$storeCode = ($storeCode) ? $storeCode : $this->getCurrentStoreCode($location);
		$theme = Mage::getStoreConfig('design/theme/default', $storeCode) ? Mage::getStoreConfig('design/theme/default', $storeCode) : "default";

		return trim($theme);
	}
	
	public function getDesignPackage($storeCode = null, $location = "frontend")
	{
		$storeCode = ($storeCode) ? $storeCode : $this->getCurrentStoreCode($location);
		$theme = Mage::getStoreConfig('design/package/name', $storeCode) ? Mage::getStoreConfig('design/package/name', $storeCode) : "default";

		return trim($theme);
	}
	
	//This function for old themes & extensions
	public function gettheme()
	{
		return $this->getDefaultTheme();
	}

	/**
	 * Get Profile Name
	 *
	 * @return string profile name
	 */
	public function getProfileName($storeCode = null){

		$cookieName = $this->getDefaultTheme()."_active_color";
		if(isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName]){
			$profileName = $_COOKIE[$cookieName];
		}else{
			if(!$storeCode)
				$storeCode = $this->getCurrentStoreCode();
			$profileName = Mage::getStoreConfig("wavethemes_jmbasetheme/jmbasethemegeneral/profile", $storeCode);
		}

		return $profileName;
	}

	//This function for old themes & extensions
	public function getprofile()
	{
		return $this->getProfileName();
	}

	public function getProfiles($storeCode = null)
	{
		if(!$storeCode)
			$storeCode = $this->getCurrentStoreCode('backend');

		$profiles = array();
		$profilecores = array();
		$profilelocals = array();

		$profiles["default"] = new stdclass();
		$profilePath = $this->getProfilePath($storeCode);

		$filecores = $this->files($profilePath . "core", '\.ini');

		if ($filecores) {
			foreach ($filecores as $file) {
				$profilecores[strtolower(substr($file, 0, -4))] = parse_ini_file($profilePath . "core" . DS . $file);
			}
		}
		$filelocals = $this->files($profilePath . DS . "local", '\.ini');
		if ($filelocals) {
			foreach ($filelocals as $file) {
				$profilelocals[strtolower(substr($file, 0, -4))] = parse_ini_file($profilePath . "local" . DS . $file);
			}
		}

		$profiles = array_merge($profilecores, $profilelocals);

		if (empty($profiles)) {
			$profiles["default"] = new stdclass();
		}
		foreach ($profiles as $profile => $settings) {
			if (file_exists($profilePath . "core" . DS . $profile . ".ini")) {
				$profiles[$profile]["iscore"] = true;
			}
		}

		return $profiles;
	}

	public function files($path, $filter = '.', $recurse = false, $fullpath = false, $exclude = array('.svn', 'CVS'))
	{
		// Initialize variables
		$arr = array();

		// Is the path a folder?
		if (!is_dir($path)) {
			return false;
		}

		// read the source directory
		$handle = opendir($path);
		while (($file = readdir($handle)) !== false) {
			if (($file != '.') && ($file != '..') && (!in_array($file, $exclude))) {
				$dir = $path . DS . $file;
				$isDir = is_dir($dir);
				if ($isDir) {
					if ($recurse) {
						if (is_integer($recurse)) {
							$arr2 = $this->files($dir, $filter, $recurse - 1, $fullpath);
						} else {
							$arr2 = $this->files($dir, $filter, $recurse, $fullpath);
						}

						$arr = array_merge($arr, $arr2);
					}
				} else {
					if (preg_match("/$filter/", $file)) {
						if ($fullpath) {
							$arr[] = $path . DS . $file;
						} else {
							$arr[] = $file;
						}
					}
				}
			}
		}
		closedir($handle);

		asort($arr);
		return $arr;
	}

	public function write_ini_file($assoc_arr, $path)
	{
		$content = "\n";
		foreach ($assoc_arr as $key => $elem) {
			if (is_array($elem)) {
				for ($i = 0; $i < count($elem); $i++) {
					$content .= $key . "[] = \"" . $elem[$i] . "\"\r\n";
				}
			} else if ($elem == "") $content .= $key . " = \r\n";
			else $content .= $key . " = \"" . $elem . "\"\r\n";
		}

		if (!$handle = fopen($path, 'w')) {
			return false;
		}
		if (!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}

	public function saveProfile($pname, $assoc_arr, $storecode = "")
	{
		return $this->write_ini_file($assoc_arr, $this->getProfilePath($storecode) . "local" . DS . $pname);
	}

	public function writeTofile($content, $path)
	{
		if (!$handle = fopen($path, 'w')) {
			return false;
		}
		if (!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}

	public function removeDir($dir) {
		$this->emptyDirectory($dir, true);
	}

	public function emptyDirectory($dirname, $self_delete = false){
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle){
			return false;
		}
		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname . DIRECTORY_SEPARATOR . $file))
					@unlink($dirname . DIRECTORY_SEPARATOR . $file);
				else
					self::emptyDirectory($dirname . DIRECTORY_SEPARATOR . $file, true);
			}
		}
		closedir($dir_handle);

		if ($self_delete){
			@rmdir($dirname);
		}

		return true;
	}

	public function getCurrentStoreCode($location = 'frontend'){
		if($location == 'frontend'){
			$storeCode = ($this->activeStoreCode) ? $this->activeStoreCode : $this->defaultStoreCode;
		}else if($location == 'backend'){
			$storeCode = Mage::app()->getRequest()->getParam('store');
			if(!$storeCode){
				$storeCode = $this->defaultStoreCode;
			}
		}

		return $storeCode;
	}

}
	 