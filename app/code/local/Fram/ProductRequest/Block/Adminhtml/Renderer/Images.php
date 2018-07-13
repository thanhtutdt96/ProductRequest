<?php

class Fram_ProductRequest_Block_Adminhtml_Renderer_Images extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $object)
    {
        if ($object->getData($this->getColumn()->getIndex()) == null) {
            return 'None';
        }
        
        $html = '<img src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $object->getData($this->getColumn()->getIndex()) . '" style="width:50px; vertical-align: middle;"';
        $html .= '/>';

        return $html;
    }
}