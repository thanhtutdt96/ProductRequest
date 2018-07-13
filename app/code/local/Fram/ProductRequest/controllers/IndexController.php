<?php

class Fram_ProductRequest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if (!Mage::helper('productrequest')->isEnabledModule()) {
            $this->_redirect("/");
        } else {
            $this->loadLayout();
            $this->renderLayout();
        }
    }

    public function submitAction()
    {
        $request = Mage::getModel('productrequest/request');
        $data = $this->getRequest()->getParams();


        if (isset($_FILES['image']['name']) && (file_exists($_FILES['image']['tmp_name']))) {
            try {
                $folderName = 'request_img';
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                $path = Mage::getBaseDir('media') . DS . $folderName . DS;

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $fileName = time() . '.' . $uploader->getFileExtension();
                $uploader->save($path, $fileName);

                $data['image'] = strtr(':pathImage', [':pathImage' => $folderName . '/' . $fileName]);
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError(Mage::helper('productrequest')->__($e->getMessage()));
            }
        }

        if (Mage::helper('productrequest')->isEmailWhenSubmitted()) {
            Mage::dispatchEvent('customer_submit_request', array('product_request' => $data));
        }

        $request->setData($data);

        try {
            $request->save();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('productrequest')->__('Request submitted. Please wait for 3-5 hours before receiving an approval email from our admin.'));
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('productrequest')->__($e->getMessage()));
        }

        $this->_redirect('*/*/');

    }
}