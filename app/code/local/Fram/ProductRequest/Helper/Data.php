<?php

class Fram_ProductRequest_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ENABLE_MODULE = 'productrequest_options/general/enable';
    const EMAIL_WHEN_SUBMITTED = 'productrequest_options/submit/enable';

    const SENDER_NAME = 'productrequest_options/submitted_email/sender_name';
    const SENDER_EMAIL = 'productrequest_options/submitted_email/sender_email';

    const ADMIN_NAME = 'productrequest_options/approval_email/admin_name';
    const ADMIN_EMAIL = 'productrequest_options/approval_email/admin_email';

    const STATUS_PENDING = -1;
    const SELECT_YES_WITH_EMAIL = 0;
    const SELECT_YES_NO_EMAIL = 1;
    const SELECT_NO = 2;

    private $store;

    public function __construct()
    {
        $this->store = Mage::app()->getStore()->getCode();
    }

    public function getApprovalStatusList()
    {
        return array(
            self::SELECT_YES_WITH_EMAIL => Mage::helper('productrequest')->__('Yes, with email'),
            self::SELECT_YES_NO_EMAIL => Mage::helper('productrequest')->__('Yes, no email'),
            self::SELECT_NO => Mage::helper('productrequest')->__('No'),
            self::STATUS_PENDING => Mage::helper('productrequest')->__('Pending')
        );
    }

    public function getApprovalSelectOptions()
    {
        return array(
            self::SELECT_YES_WITH_EMAIL => Mage::helper('productrequest')->__('Yes, with email'),
            self::SELECT_YES_NO_EMAIL => Mage::helper('productrequest')->__('Yes, no email'),
            self::SELECT_NO => Mage::helper('productrequest')->__('No'),
        );
    }

    public function getSenderEmail()
    {
        return Mage::getStoreConfig(self::SENDER_EMAIL, $this->store);
    }

    public function getSenderName()
    {
        return Mage::getStoreConfig(self::SENDER_NAME, $this->store);
    }

    public function getAdminName()
    {
        return Mage::getStoreConfig(self::ADMIN_NAME, $this->store);
    }

    public function getAdminEmail()
    {
        return Mage::getStoreConfig(self::ADMIN_EMAIL, $this->store);
    }

    public function isEnabledModule()
    {
        return Mage::getStoreConfig(self::ENABLE_MODULE, $this->store);
    }

    public function isEmailWhenSubmitted()
    {
        return Mage::getStoreConfig(self::EMAIL_WHEN_SUBMITTED, $this->store);
    }

    public function disableModule($moduleName)
    {
        $outputPath = "advanced/modules_disable_output/$moduleName";
        if (!Mage::getStoreConfig($outputPath)) {
            Mage::getModel('core/config')->saveConfig($outputPath, true);
        }
    }

    public function enableModule($moduleName)
    {
        $outputPath = "advanced/modules_disable_output/$moduleName";
        if (Mage::getStoreConfig($outputPath)) {
            Mage::getModel('core/config')->saveConfig($outputPath, false);
        }
    }
}