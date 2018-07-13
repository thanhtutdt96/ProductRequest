<?php

class Fram_ProductRequest_Model_Request extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('productrequest/request');
    }

    protected function _beforeSave()
    {
        if ($this->isObjectNew()) {
            $this->setCreatedAt(Mage::getModel('core/date')->timestamp());
        } else {
            $this->setUpdatedAt(Mage::getModel('core/date')->timestamp());
        }
        return parent::_beforeSave();
    }
}