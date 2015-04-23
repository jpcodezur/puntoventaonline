<?php
class Wavethemes_Jmquickview_Helper_Data extends Mage_Core_Helper_Abstract
{
    var $defaultStoreCode = null;
    var $activeStoreCode = null;

    public function __construct()
    {
        //initial default store code
        $this->defaultStoreCode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();

        //initial current store code
        $this->activeStoreCode = Mage::app()->getStore()->getCode();
    }

    public function get($var, $attributes)
    {
        $value = null;
        if(isset($attributes[$var])){
            $value = $attributes[$var];
        }else{
            $storeCode = ($this->activeStoreCode) ? $this->activeStoreCode : $this->defaultStoreCode;
            $configGroups = Mage::getStoreConfig("wavethemes_jmquickview", $storeCode);
            foreach($configGroups as $configs){
                if(isset($configs[$var])){
                    $value = $configs[$var];
                    break;
                }
            }
        }

        return $value;
    }
}
	 