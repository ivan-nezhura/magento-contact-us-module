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
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\Data\Form\Element\Fieldset
     */
    protected $_fieldset;

    /**
     * Reply constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Data\Form\Element\Fieldset $fieldset,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_fieldset = $fieldset;

        parent::__construct($context, $data);
    }

    /**
     * @return string reply customer block
     */
    protected function _toHtml()
    {
        $editForm = $this->_coreRegistry->registry('nezhura_contact_us_edit_form');

        if ($editForm === null) {
            return '';
        }

        $this->_fieldset->setForm($editForm);

        $this->_fieldset->setLegend(__('Reply customer'));

        $this->_fieldset->addField(
            'comment',
            'textarea',
            [
                'name' => 'response_message',
                'label' => __('Response text'),
            ]
        );

        $this->_fieldset->addField(
            'response',
            'submit',
            [
                'name' => 'response',
                'value' => __('Reply'),
            ]
        );

        return $this->_fieldset->getHtml();
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
