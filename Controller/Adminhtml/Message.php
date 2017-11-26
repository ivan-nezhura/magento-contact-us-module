<?php

namespace Nezhura\ContactUs\Controller\Adminhtml;

/**
 * Class Message
 * @package Nezhura\ContactUs\Controller\Adminhtml\Message
 */
abstract class Message extends \Magento\Backend\App\Action
{
    /**
     * @var \Nezhura\ContactUs\Model\MessageFactory
     */
    protected $_messageFactory;

    /**
     * @var \Nezhura\ContactUs\Model\ResourceModel\MessageFactory
     */
    protected $_resourceMessageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Nezhura\ContactUs\Model\System\Config\StatusFactory
     */
    protected $_statusFactory;

    /**
     * Message constructor.
     * @param \Nezhura\ContactUs\Model\MessageFactory $messageFactory
     * @param \Nezhura\ContactUs\Model\ResourceModel\MessageFactory $resourceMessageFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Nezhura\ContactUs\Model\MessageFactory $messageFactory,
        \Nezhura\ContactUs\Model\ResourceModel\MessageFactory $resourceMessageFactory,
        \Nezhura\ContactUs\Model\System\Config\StatusFactory $statusFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_messageFactory = $messageFactory;
        $this->_resourceMessageFactory = $resourceMessageFactory;
        $this->_statusFactory = $statusFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Nezhura\ContactUs\Model\Message
     */
    protected function _getMessage()
    {
        $messageId = (int)$this->getRequest()->getParam('id');

        $message = $this->_messageFactory->create();

        $resourceMessage = $this->_resourceMessageFactory->create();

        if (!empty($messageId)) {
            $resourceMessage->load($message, $messageId);
        }

        return $message;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface redirects to INDEX action
     */
    protected function _redirectToIndex()
    {
        return $this->_redirect($this->getUrl('contact_us/message/index'));
    }
}
