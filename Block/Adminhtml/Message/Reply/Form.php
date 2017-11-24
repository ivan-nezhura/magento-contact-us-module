<?php
namespace Nezhura\ContactUs\Block\Adminhtml\Message\Reply;

use Magento\Framework\Data\Form\Element\Submit;
use Magento\Framework\Data\Form\Element\Textarea;

/**
 * Class Form
 * @package Nezhura\ContactUs\Block\Adminhtml\Message\Reply
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();


        $fieldset = $form->addFieldset('contact_us_reply_form_fieldset', []);

        $fieldset->addField(
            'reply_message',
            Textarea::class,
            [
                'name' => 'reply_message',
                'title' => __('Response'),
                'label' => __('Response'),
                'required' => true,
            ]
        );

        $form->addField(
            'submit',
            Submit::class,
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
        $this->setForm($form);

        return parent::_prepareForm();
    }
}