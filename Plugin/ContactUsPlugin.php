<?php
namespace Nezhura\ContactUs\Plugin;

use Magento\Contact\Controller\Index\Post;
use Magento\Framework\DataObject;

/**
 * Class ContactUsPlugin
 * @package Nezhura\ContactUs\Plugin
 */
class ContactUsPlugin extends Post
{
    /**
     * @var \Nezhura\ContactUs\Model\ContactUsFactory
     */
    protected $_contactUsFactory;

    /**
     * @var \Nezhura\ContactUs\Model\ResourceModel\ContactUsFactory
     */
    protected $_contactUsResourceFactory;

    /**
     * ContactUsPlugin constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Nezhura\ContactUs\Model\ContactUsFactory $contactUsFactory
     * @param \Nezhura\ContactUs\Model\ResourceModel\ContactUsFactory $contactUsResourceFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Nezhura\ContactUs\Model\ContactUsFactory $contactUsFactory,
        \Nezhura\ContactUs\Model\ResourceModel\ContactUsFactory $contactUsResourceFactory
    ) {
        $this->_contactUsFactory = $contactUsFactory;
        $this->_contactUsResourceFactory = $contactUsResourceFactory;

        parent::__construct(
            $context,
            $transportBuilder,
            $inlineTranslation,
            $scopeConfig,
            $storeManager
        );
    }

    /**
     * Handler for form submitting
     *
     * @return void
     * @throws \Exception
     */
    public function aroundExecute()
    {
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect('*/*/');
            return;
        }

        $this->inlineTranslation->suspend();
        try {
            $postObject = new DataObject();
            $postObject->setData($post);

            $error = false;

            if (!\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['comment']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                $error = true;
            }
            if ($error) {
                throw new \Exception();
            }

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, $storeScope))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
                ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
                ->setReplyTo($post['email'])
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();

            // plugin point start
            $resourceModel = $this->_contactUsResourceFactory->create();
            $model = $this->_contactUsFactory->create();
            $model->setData($post);
            $resourceModel->save($model);
            // plugin point end

            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            $this->_redirect('contact/index');
            return;
        } catch (\Exception $e) {

            $this->inlineTranslation->resume();
            $this->messageManager->addErrorMessage(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->_redirect('contact/index');
            return;
        }
    }
}
