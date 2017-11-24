<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

/**
 * Class Index
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var bool|\Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Nezhura_ContactUs::contact_us_form_data');
        $resultPage->getConfig()->getTitle()->prepend(__('\'Contact us\' messages'));

        return $resultPage;
    }
}