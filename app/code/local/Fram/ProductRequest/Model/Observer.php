<?php

class Fram_ProductRequest_Model_Observer
{

    public function customerSubmitRequest($observer)
    {
        $data = $observer->getEvent()->getProductRequest();

        $customerEmail = $data['customer_email'];
        $customerName = $data['customer_name'];

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        $sender = array('name' => Mage::helper('productrequest')->getSenderName(), 'email' => Mage::helper('productrequest')->getSenderEmail());

        $emailTemplate = Mage::getModel('core/email_template');
        $emailTemplate->setDesignConfig(array('area' => 'frontend'))
            ->sendTransactional('customer_submit_request_template', $sender, $customerEmail, $customerName, array('name' => $customerName));

        $translate->setTranslateInline(true);
    }

    public function adminApproveRequest($observer)
    {
        $data = $observer->getEvent()->getProductRequest();

        $customerEmail = $data['customer_email'];
        $customerName = $data['customer_name'];

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        $sender = array('name' => Mage::helper('productrequest')->getAdminName(), 'email' => Mage::helper('productrequest')->getAdminEmail());

        $emailTemplate = Mage::getModel('core/email_template');
        $emailTemplate->setDesignConfig(array('area' => 'frontend'))
            ->sendTransactional('admin_approve_request_template', $sender, $customerEmail, $customerName, array('name' => $customerName));

        $translate->setTranslateInline(true);
    }

    public function adjustModuleState()
    {
        if (!Mage::helper('productrequest')->isEnabledModule()) {
            Mage::helper('productrequest')->disableModule('Fram_ProductRequest');
        } else {
            Mage::helper('productrequest')->enableModule('Fram_ProductRequest');
        }
    }

}