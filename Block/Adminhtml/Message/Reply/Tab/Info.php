<?php

namespace Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Nezhura\ContactUs\Model\System\Config\Status;

/**
 * Class Info
 * @package Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab
 */
class Info extends Generic implements TabInterface
{

    /**
     * @var \Nezhura\ContactUs\Model\System\Config\Status
     */
    protected $_newsStatus;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Status $messageStatus
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Status $messageStatus,
        array $data = []
    ) {
        $this->_newsStatus = $messageStatus;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /* @var $model \Nezhura\ContactUs\Model\Message */
        $model = $this->_coreRegistry->registry('nezhura_contact_us_message');

        /* @var $form \Magento\Framework\Data\Form  */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('message_');
        $form->setFieldNameSuffix('message');

        $fieldSet = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Message info')]
        );

        $fieldSet->addField(
            'contact_us_id',
            'hidden',
            ['name' => 'contact_us_id']
        );

        $fieldSet->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Customer name'),
                'readonly' => true
            ]
        );

        $fieldSet->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Customer email'),
                'readonly' => true
            ]
        );

        $fieldSet->addField(
            'telephone',
            'text',
            [
                'name' => 'telephone',
                'label' => __('Customer phone'),
                'readonly' => true
            ]
        );

        $fieldSet->addField(
            'comment',
            'textarea',
            [
                'name' => 'comment',
                'label' => __('Message'),
                'readonly' => true
            ]
        );

        $fieldSet->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'options' => $this->_newsStatus->toOptionArray()
            ]
        );

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Message Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Message Info');
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
