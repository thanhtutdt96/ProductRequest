<?php

class Fram_ProductRequest_Block_Adminhtml_Container extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'productrequest';
        $this->_controller = 'adminhtml_container';
        $this->_headerText = Mage::helper('productrequest')->__('Manage Customer Request');

        $this->updateButton('add', 'label', Mage::helper('productrequest')->__('Add Request'));
        $this->addButton('export', array(
            'label' => Mage::helper('productrequest')->__('Export to CSV'),
            'onclick' => "setLocation('{$this->getUrl('*/*/exportCsv')}')"
        ));
    }
}