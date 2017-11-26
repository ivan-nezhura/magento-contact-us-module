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
 * Class Reply
 * @package Nezhura\ContactUs\Block\Adminhtml\Message\Reply\Tab
 */
class Reply extends Generic implements TabInterface
{
    /**
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /* @var $model \Nezhura\ContactUs\Model\Message */
        $model = $this->_coreRegistry->registry('nezhura_contact_us_message');

        /* @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();


        $fieldset = $form->addFieldset('contact_us_reply_form_fieldset', []);

        $fieldset->addField(
            'reply_message',
            \Magento\Framework\Data\Form\Element\Textarea::class,
            [
                'name' => 'reply_message',
                'title' => __('Response'),
                'label' => __('Response'),
                'required' => true,
            ]
        );

        $form->addField(
            'submit',
            \Magento\Framework\Data\Form\Element\Submit::class,
            [
                'name' => 'reply',
                'value' => __('Reply'),
                'title' => __('Reply to customer'),
                'label' => __('Reply to customer'),
                'class' => 'action-default'
            ]
        );

        $form->setMethod('post');
        $form->setId('contact_us_reply_form');
        $form->setUseContainer(true);
        $form->setAction($this->getUrl('contact_us/message/response'));

//        $this->

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
