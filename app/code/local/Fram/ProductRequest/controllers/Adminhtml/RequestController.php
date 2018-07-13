<?php

class Fram_ProductRequest_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{
    public $isAlreadyApproved;

    public function _initAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('productrequest')->__('Manage Customer Request'));
        $this->_setActiveMenu('productrequest');
        $this->renderLayout();
    }

    public function indexAction()
    {
        $this->_initAction();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->isAlreadyApproved = false;

        $id = $this->getRequest()->getParam('id');
        $request = Mage::getModel('productrequest/request')->load($id);

        if ($request->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

            if (!empty($data)) {
                $request->setData($data);
            }

            Mage::register('productrequest_data', $request);

            $this->loadLayout();
            $this->_addContent($this->getLayout()->createBlock('productrequest/adminhtml_container_edit'))
                ->_addLeft($this->getLayout()->createBlock('productrequest/adminhtml_container_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productrequest')->__('Request does not exist'));
            $this->_redirect("*/*/");
        }
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            $request = Mage::getModel('productrequest/request');

            if ($id) {
                $request->load($id);
            }

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
            } else {
                if (isset($data['image']['delete']) && $data['image']['delete'] == 1)
                    $data['image'] = '';
                else
                    unset($data['image']);
            }

            $request->setData($data);

            if ($id) {
                $request->setId($id);
            }

            try {
                $request->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productrequest')->__('Request saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($data['is_approved'] == 0 && $data['updated_at'] == null) {
                    Mage::dispatchEvent('admin_approve_request', array('product_request' => $data));
                }

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $request->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $request->getId()));
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productlisting')->__('Unable to save product'));
        $this->_redirect('*/*/');

    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productrequest')->__('Request does not exist'));
        } else {
            if (!empty($id)) {
                try {
                    $request = Mage::getSingleton('productrequest/request')->load($id);
                    $request->delete();
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productrequest')->__('Request was successfully deleted'));
                    $this->_redirect('*/*/index');
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('request');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError('Please select one or more requests');
        } else {
            try {
                $request = Mage::getSingleton('productrequest/request');
                foreach ($ids as $id) {
                    $request->load($id);
                    $request->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productrequest')->__('Total of %d request(s) were deleted', count($ids)));

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massApproveAction()
    {
        $ids = $this->getRequest()->getParam('request');
        $select = $this->getRequest()->getParam('select');

        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError('Please select one or more requests');
        } else {
            try {
                $approved = 0;
                $request = Mage::getSingleton('productrequest/request');
                foreach ($ids as $id) {
                    $request->load($id);

                    $data = $request->getData();
                    $approvalStatus = $request->getIsApproved();

                    if ($approvalStatus == -1 || $approvalStatus == 2) {
                        $approved++;
                    }

                    $request->setIsApproved($select);
                    $request->save();

                    if ($select == 0) {
                        Mage::dispatchEvent('admin_approve_request', array('product_request' => $data));
                    }
                }
                if ($approved == 0) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productrequest')->__('Request(s) were already approved'));
                } else {
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productrequest')->__('Total of %d request(s) were approved', $approved));
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName = 'request_list_' . date("Y-m-d_H-i", strtotime(now())) . '.csv';
        $content = $this->getLayout()->createBlock('productrequest/adminhtml_container_grid')->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }


}