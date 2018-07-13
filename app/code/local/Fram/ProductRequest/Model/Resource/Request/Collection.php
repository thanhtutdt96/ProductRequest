<?php

class Fram_ProductRequest_Model_Resource_Request_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('productrequest/request');
    }
}