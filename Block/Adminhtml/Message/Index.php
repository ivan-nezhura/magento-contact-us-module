<?php
namespace Nezhura\ContactUs\Block\Adminhtml\Message;

/**
 * Class Index
 * @package Nezhura\ContactUs\Block\Adminhtml
 */
class Index extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_message_index';
        $this->_blockGroup = 'Nezhura_ContactUs';
        $this->_headerText = __('Messages');

        parent::_construct();
    }

    /**
     * Prevent adding 'add new' button
     *
     * @return void
     */
    protected function _addNewButton()
    {
    }
}