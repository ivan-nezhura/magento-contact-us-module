<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

/**
 * Class Response
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Response extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        dump('handle reply', $this->getRequest()->getParams());
    }
}