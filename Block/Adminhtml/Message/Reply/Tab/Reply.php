<?php
namespace Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab;

use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Ui\Component\Form\Element\Textarea;

/**
 * Class Reply
 * @package Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab
 */
class Reply extends \Magento\Framework\View\Element\AbstractBlock
    implements TabInterface
{
    /**
     * @return string reply customer textarea block
     */
    protected function _toHtml()
    {
        return '<textarea name="response_message"></textarea><button name="response">send response</button>';
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Reply customer');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Reply customer');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
