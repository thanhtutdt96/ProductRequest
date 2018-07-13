<?php

class Fram_ProductRequest_Block_Adminhtml_Container_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productrequest_id');
        $this->setDefaultDir('asc');
        $this->setDefaultSort('id');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productrequest/request')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('productrequest')->__('Request Id'),
            'align' => 'right',
            'type' => 'text',
            'width' => '60px',
            'index' => 'id'
        ));

        $this->addColumn('customer_name', array(
            'header' => Mage::helper('productrequest')->__('Customer Name'),
            'index' => 'customer_name',
            'type' => 'text',
        ));

        $this->addColumn('customer_email', array(
            'header' => Mage::helper('productrequest')->__('Customer Email'),
            'type' => 'text',
            'index' => 'customer_email'
        ));

        $this->addColumn('comment', array(
            'header' => Mage::helper('productrequest')->__('Comment'),
            'type' => 'text',
            'index' => 'comment'
        ));

        $this->addColumn('image', array(
            'header' => Mage::helper('productrequest')->__('Image'),
            'align' => 'center',
            'index' => 'image',
            'width' => '60px',
            'renderer' => 'Fram_ProductRequest_Block_Adminhtml_Renderer_Images'
        ));

        $this->addColumn('is_approved', array(
            'header' => Mage::helper('productrequest')->__('Approval Status'),
            'type' => 'options',
            'index' => 'is_approved',
            'options' => Mage::helper('productrequest')->getApprovalStatusList()
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('productrequest')->__('Date Created'),
            'type' => 'datetime',
            'index' => 'created_at'
        ));

        $this->addColumn('updated_at', array(
            'header' => Mage::helper('productrequest')->__('Date Updated'),
            'type' => 'datetime',
            'index' => 'updated_at'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('request');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('productrequest')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('productrequest')->__('Are you sure to delete these requests ?')
        ));

        $this->getMassactionBlock()->addItem('approve', array(
            'label' => Mage::helper('productrequest')->__('Approve'),
            'url' => $this->getUrl('*/*/massApprove'),
            'confirm' => Mage::helper('productrequest')->__('Are you sure to approve these requests ?'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'select',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('productrequest')->__('Select'),
                    'values' => Mage::helper('productrequest')->getApprovalSelectOptions()
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getId()
        ));
    }
}