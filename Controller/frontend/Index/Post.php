<?php
namespace Nezhura\ContactUs\Controller\frontend\Index;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;

class Post extends \Magento\Contact\Controller\Index
{
    /**
     * @var DataPersistorInterface
     */
    private $_dataPersistor;

    /**
     * @var \Nezhura\ContactUs\Model\ContactUsFactory
     */
    protected $_contactUsFactory;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Nezhura\ContactUs\Model\ContactUsFactory $contactUsFactory
    ) {
        parent::__construct(
            $context,
            $transportBuilder,
            $inlineTranslation,
            $scopeConfig,
            $storeManager
        );

        $this->_contactUsFactory = $contactUsFactory;
    }

    /**
     * Post user question
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
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

            $this->_validateData($postObject);
            $this->_sendMail($postObject);
            $this->_saveFormData($postObject);

            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            $this->_getDataPersistor()->clear('contact_us');
            $this->_redirect('contact/index');
            return;
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->messageManager->addErrorMessage(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->_getDataPersistor()->set('contact_us', $post);
            $this->_redirect('contact/index');
            return;
        }
    }

    /**
     * @param DataObject $object
     */
    protected function _saveFormData(DataObject $object)
    {
        $contactUs = $this->_contactUsFactory->create();
        $contactUs->setData('name', $object->getData('name'));
        $contactUs->setData('email', $object->getData('email'));
        $contactUs->setData('comment', $object->getData('comment'));
        $contactUs->setData('name', $object->getData('name'));
        dump($object);
    }

    /**
     * @param DataObject $object
     * @throws \Exception
     */
    protected function _validateData(DataObject $object)
    {
        $error = false;

        if (!\Zend_Validate::is(trim($object['name']), 'NotEmpty')) {
            $error = true;
        }
        if (!\Zend_Validate::is(trim($object['comment']), 'NotEmpty')) {
            $error = true;
        }
        if (!\Zend_Validate::is(trim($object['email']), 'EmailAddress')) {
            $error = true;
        }
        if (\Zend_Validate::is(trim($object['hideit']), 'NotEmpty')) {
            $error = true;
        }

        if ($error) {
            throw new \Exception();
        }
    }

    /**
     * @param DataObject $object
     */
    protected function _sendMail(DataObject $object)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, $storeScope))
            ->setTemplateOptions(
                [
                    'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $object])
            ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
            ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
            ->setReplyTo($object['email'])
            ->getTransport();

        $transport->sendMessage();
    }



    /**
     * Get Data Persistor
     *
     * @return DataPersistorInterface
     */
    private function _getDataPersistor()
    {
        if ($this->_dataPersistor === null) {
            $this->_dataPersistor = ObjectManager::getInstance()
                ->get(DataPersistorInterface::class);
        }

        return $this->_dataPersistor;
    }
}