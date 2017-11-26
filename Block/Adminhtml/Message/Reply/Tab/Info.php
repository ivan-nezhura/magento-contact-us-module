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

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('message_');
        $form->setFieldNameSuffix('message');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Message info')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'contact_us_id',
                'hidden',
                ['name' => 'contact_us_id']
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Customer name'),
                'readonly' => true
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Customer email'),
                'readonly' => true
            ]
        );

        $fieldset->addField(
            'telephone',
            'text',
            [
                'name' => 'telephone',
                'label' => __('Customer phone'),
                'readonly' => true
            ]
        );

        $fieldset->addField(
            'comment',
            'textarea',
            [
                'name' => 'comment',
                'label' => __('Message'),
                'readonly' => true
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'options' => $this->_newsStatus->toOptionArray()
            ]
        );

        $data = $model->getData();
        $form->setValues($data);

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
