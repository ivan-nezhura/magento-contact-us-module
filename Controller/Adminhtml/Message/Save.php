<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

use Magento\Reports\Test\TestCase\SalesTaxReportEntityTest;
use Nezhura\ContactUs\Controller\Adminhtml\Message as BaseAction;
use Nezhura\ContactUs\Model\Message;
use Nezhura\ContactUs\Model\System\Config\Status;

/**
 * Class Response
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Save extends BaseAction
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;


    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * Save constructor.
     * @param \Nezhura\ContactUs\Model\MessageFactory $messageFactory
     * @param \Nezhura\ContactUs\Model\ResourceModel\MessageFactory $resourceMessageFactory
     * @param \Nezhura\ContactUs\Model\System\Config\StatusFactory $statusFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Nezhura\ContactUs\Model\MessageFactory $messageFactory,
        \Nezhura\ContactUs\Model\ResourceModel\MessageFactory $resourceMessageFactory,
        \Nezhura\ContactUs\Model\System\Config\StatusFactory $statusFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_authSession = $authSession;

        parent::__construct(
            $messageFactory,
            $resourceMessageFactory,
            $statusFactory,
            $coreRegistry,
            $resultPageFactory,
            $context
        );
    }

    /**
     * handles saving record (only 'status' field can be changed by user)
     *
     * @inheritdoc
     */
    public function execute()
    {
        $postData = $this->_request->getPostValue('message');

        if (!empty($postData) && !empty($postData['contact_us_id'])) {
            $message = $this->_messageFactory->create();

            $resourceMessage = $this->_resourceMessageFactory->create();

            $resourceMessage->load($message, (int)$postData['contact_us_id']);

            $statuses = $this->_statusFactory->create();

            if ($message->getId()){
                try {
                    if ($this->_request->getPostValue('response') !== null) {
                        $newStatus = Message::STATUS_PROCESSED;

                        $this->_sendResponse(
                            $message->getData('email'),
                            $this->_request->getPostValue('response_message')
                        );

                    } else {
                        $newStatus = (int)$postData['status'];
                    }

                    if (
                        !in_array(
                            $postData['status'],
                            $statuses->getValidStatuses()
                        )
                    ) {
                        throw new \Exception('Status is invalid');
                    }

                    $message->setData('status', $newStatus);

                    $resourceMessage->save($message);

                    $this->messageManager->addSuccessMessage(
                        __('Message was updated.')
                    );
                } catch (\Exception $exception) {
                    $this->messageManager->addSuccessMessage(
                        __('Error occurred: %1.', $exception->getMessage())
                    );
                }
            }
        }

        return $this->_redirectToIndex();
    }

    /**
     * @param $customerEmail string
     * @param $message string
     *
     * @throws \Exception if $message is blank
     */
    protected function _sendResponse($customerEmail, $message)
    {
        if (!\Zend_Validate::is(trim($message), 'NotEmpty')) {
            throw new \Exception(__('Response can not be blank'));
        }

        $transport = $this->_transportBuilder
            ->setTemplateIdentifier('nezhura_contact_us_response')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['message' => $message])
            ->setFrom( [
                'email' => $this->_authSession->getUser()->getEmail(),
                'name' => $this->_authSession->getUser()->getName()
            ])
            ->addTo($customerEmail)
            ->getTransport();

        $transport->sendMessage();

        $this->messageManager->addSuccessMessage(
            __('Response was sent.')
        );
    }
}