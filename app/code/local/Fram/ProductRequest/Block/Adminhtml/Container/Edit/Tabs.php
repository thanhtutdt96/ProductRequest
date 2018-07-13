<?php

class Fram_ProductRequest_Block_Adminhtml_Container_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('productrequest')->__('Manage Request'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => 'Basic Info',
            'title' => 'Basic',
            'content' => $this->getLayout()->createBlock('productrequest/adminhtml_container_edit_tabs_form')->toHtml()
        ));
        return parent::_beforeToHtml();
    }
}