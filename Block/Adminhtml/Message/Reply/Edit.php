<?php
namespace Nezhura\ContactUs\Block\Adminhtml\Message\Reply;


/**
 * Class Edit
 * @package Nezhura\ContactUs\Block\Adminhtml\Message
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var string
     */
    protected $_controller = 'adminhtml_message';

    /**
     * @var string
     */
    protected $_blockGroup = 'Nezhura_ContactUs';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->buttonList->add(
            'reply_customer',
            [
                'label' => __('Reply customer'),
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'target' => '#edit_form'
                        ],
                    ],

                ]
            ]
        );
    }
}
