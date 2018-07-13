<?php

class Fram_ProductRequest_Block_Adminhtml_Container_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('request_form', array(
            'legend' => 'Request Information'
        ));

        $fieldset->addField('customer_name', 'text', array(
            'label' => Mage::helper('productrequest')->__('Customer Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'customer_name',
        ));

        $fieldset->addField('customer_email', 'text', array(
            'label' => Mage::helper('productrequest')->__('Customer Email'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'customer_email'
        ));

        $fieldset->addField('comment', 'textarea', array(
            'label' => Mage::helper('productrequest')->__('Comment'),
            'required' => true,
            'name' => 'comment',
            'style' => 'height:150px'
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('productrequest')->__('Image'),
            'required' => false,
            'name' => 'image',
            'note' => '(*.jpg, *.png)'
        ));

        $fieldset->addField('is_approved', 'select', array(
            'label' => Mage::helper('productrequest')->__('Approval Status'),
            'required' => false,
            'name' => 'is_approved',
            'value' => '-1',
            'values' => Mage::helper('productrequest')->getApprovalStatusList()
        ));

        $fieldset->addField('updated_at', 'hidden', array(
            'label' => Mage::helper('productrequest')->__('Updated Date'),
            'required' => false,
            'name' => 'updated_at',
            'readonly' => true
        ));
        $request = Mage::registry('productrequest_data');

        if ($request) {
            $form->setValues($request);
        }

        return parent::_prepareForm();
    }
}