<?php
namespace Nezhura\ContactUs\Block\Adminhtml\Message\Reply;

/**
 * Class Tabs
 * @package Nezhura\ContactUs\Block\Adminhtml\Message\Reply
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('message_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('\'Contact Us\' message'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'message_info',
            [
                'label' => __('Message info'),
                'title' => __('Message info'),
                'content' => $this->getLayout()->createBlock(
                    'Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );

        /*$this->addTab(
            'message_reply',
            [
                'label' => __('Reply'),
                'title' => __('Reply'),
                'content' => $this->getLayout()->createBlock(
                    'Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab\Reply'
                )->toHtml(),
            ]
        );*/

        return parent::_beforeToHtml();
    }
}
