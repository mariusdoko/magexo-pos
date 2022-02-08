<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magexo\Pos\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use  Magexo\Pos\Model\Magexopos;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    
    protected $dataProcessor;
    protected $dataPersistor;
    protected $model;

    public function __construct(
        \Magento\Backend\App\Action\Context  $context,
        DataProcessor $dataProcessor,
        Magexopos $model,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->model = $model;
        parent::__construct($context);
    }

    public function execute()
    {
        
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {


            $data = $this->dataProcessor->filter($data);
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $this->model->load($id);
                
            }

            
            $data['name'] = ucfirst($data['name']);
            $this->model->setData($data);
            $this->_eventManager->dispatch(
                'magexopos_prepare_save',
                ['Magexopos' => $this->model, 'request' => $this->getRequest()]
            );

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->model->getId(), '_current' => true]);
            }

            try {

                $this->model->save();
                $id = $this->model->getId();
                $this->messageManager->addSuccess(__('You saved the Pos Entity.'));
                $this->dataPersistor->clear('Magexopos');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $this->model->getId(),
                         '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Magexopos.'));
            }

            $this->dataPersistor->set('Magexopos', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
