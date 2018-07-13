<?php

class Fram_ProductRequest_Block_Adminhtml_Container_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

   public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_mode = 'edit';
        $this->_blockGroup = 'productrequest';
        $this->_controller = 'adminhtml_container';

        $this->updateButton('update', 'label', Mage::helper('productrequest')->__('Save Request'));
        $this->updateButton('delete', 'label', Mage::helper('productrequest')->__('Delete Request'));
    }

    public function getHeaderText()
    {
        if (Mage::registry('productrequest_data') && Mage::registry('productrequest_data')->getId()) {
            return 'Edit request from customer: ' . Mage::registry('productrequest_data')->getCustomerName();
        } else {
            return 'Add a new request';
        }
    }
}