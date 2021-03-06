<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * System config image field backend model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Wavethemes_Jmbasetheme_Model_Backend_Image extends Mage_Adminhtml_Model_System_Config_Backend_File
{
    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return array
     */
    protected function _getAllowedExtensions()
    {
        return array('jpg', 'jpeg', 'gif', 'png');
    }
    
     /**
     * Return the root part of directory path for uploading
     *
     * @var string
     * @return string
     */
     protected function _beforeSave()
    {
        $value = $this->getValue();
        if ($_FILES['groups']['tmp_name'][$this->getGroupId()]['fields'][$this->getField()]['value']){
            $uploadDir = $this->_getUploadDir();
            try {
                $file = array();
                $tmpName = $_FILES['groups']['tmp_name'];
                $file['tmp_name'] = $tmpName[$this->getGroupId()]['fields'][$this->getField()]['value'];
                $name = $_FILES['groups']['name'];
                $file['name'] = $name[$this->getGroupId()]['fields'][$this->getField()]['value'];
                $url = getimagesize($uploadDir.DS.$file['name']); //print_r($url); returns an array
                if (is_array($url)) 
                {
                    $fieldConfig = $this->getFieldConfig();
                    Mage::throwException($fieldConfig->label.Mage::helper('core')->__("with same name existed"));
                }else {
                    $uploader = new Mage_Core_Model_File_Uploader($file);
                    $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                    $uploader->setAllowRenameFiles(true);
                    $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                    $result = $uploader->save($uploadDir);
                }
            } catch (Exception $e) {
                Mage::throwException($e->getMessage());
                return $this;
            }
            $filename = $result['file'];

            if ($filename) {
                if ($this->_addWhetherScopeInfo()) {
                    $filename = $this->_prependScopeInfo($filename);
                }
                $this->setValue($filename);
            }
        } else {
            if (is_array($value) && !empty($value['delete'])) {
                $this->setValue('');
            } else {
                $this->unsValue();
            }
        }
        return $this;
    }

	/**
	 * Return path to directory for upload file
	 *
	 * @return string
	 * @throw Mage_Core_Exception
	 */
	protected function _getUploadDir()
	{
		$fieldConfig = $this->getFieldConfig();
		/* @var $fieldConfig Varien_Simplexml_Element */

		if (empty($fieldConfig->upload_dir)) {
			Mage::throwException(Mage::helper('catalog')->__('The base directory to upload file is not specified.'));
		}

		$uploadDir = (string)$fieldConfig->upload_dir;

		$el = $fieldConfig->descend('upload_dir');

		/**
		 * Add scope info
		 */
		if (!empty($el['scope_info'])) {
			$uploadDir = $this->_appendScopeInfo($uploadDir);
		}

		/**
		 * Take root from config
		 */
		if (!empty($el['config'])) {
			$uploadRoot = $this->_getUploadRoot((string)$el['config']);
			$uploadDir = $uploadRoot . '/' . $uploadDir;
		}
		return $uploadDir;
	}

	/**
	 * Prepend path with scope info
	 *
	 * E.g. 'stores/2/path' , 'websites/3/path', 'default/path'
	 *
	 * @param string $path
	 * @return string
	 */
	protected function _prependScopeInfo($path)
	{
		$scopeInfo = $this->getScope();
		if ('default' != $this->getScope()) {
			$scopeInfo .= '/' . $this->getScopeId();
		}
		return $scopeInfo . '/' . $path;
	}

	/**
	 * Add scope info to path
	 *
	 * E.g. 'path/stores/2' , 'path/websites/3', 'path/default'
	 *
	 * @param string $path
	 * @return string
	 */
	protected function _appendScopeInfo($path)
	{
		$path .= '/' . $this->getScope();
		if ('default' != $this->getScope()) {
			$path .= '/' . $this->getScopeId();
		}
		return $path;
	}

    protected function _getUploadRoot($token)
    {
        $groups = Mage::app()->getRequest()->getPost('groups');
        $profile = $groups['jmbasethemegeneral']['fields']['profile']['value'];
        if(!$profile){
            $profile = Mage::getStoreConfig("wavethemes_jmbasetheme/jmbasethemegeneral/profile");
        }

		$currentStoreCode = Mage::app()->getRequest()->getParam('store');
		if(!$currentStoreCode)
			$currentStoreCode = Mage::app()->getWebsite(true)->getDefaultStore()->getCode();

        $cssfolder = Mage::helper("jmbasetheme")->getSkinProfilePath($currentStoreCode);

        return $cssfolder.DS.$profile.DS;
    }
}
