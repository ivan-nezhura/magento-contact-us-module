<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

use Nezhura\ContactUs\Controller\Adminhtml\Message as BaseAction;

/**
 * Class Edit
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Reply extends BaseAction
{
    /**
     * handles VIEW action
     *
     * @inheritdoc
     */
    public function execute()
    {
        $message = $this->_getMessage();

        // only existing records
        if (!$message->getId()) {
            $this->messageManager->addErrorMessage(__('Message was not found.'));

            return $this->_redirectToIndex();
        }

        $this->_coreRegistry->register('nezhura_contact_us_message', $message);

        /* @var $resultPage \Magento\Backend\Model\View\Result\Page */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Nezhura_ContactUs::contact_us_form_data');
        $resultPage->getConfig()->getTitle()->prepend(__('\'Contact us\' messages'));

        return $resultPage;
    }
}