<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

use Nezhura\ContactUs\Controller\Adminhtml\Message as BaseAction;
use Nezhura\ContactUs\Model\System\Config\Status;

/**
 * Class Response
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Save extends BaseAction
{
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

            if ($message->getId()){
                try {
                    if (
                    !in_array(
                        $postData['status'],
                        $this->_statusFactory->create()->getValidStatuses()
                    )
                    ) {
                        throw new \Exception('Status is invalid');
                    }

                    $message->setStatus((int)$postData['status']);

                    $resourceMessage->save($message);

                    $this->messageManager->addSuccessMessage(
                        __('Message was updated.')
                    );
                } catch (\Exception $exception) {
                    $this->messageManager->addSuccessMessage(
                        __(
                            'Error occurred: %s. Message was not updated.',
                            $exception->getMessage()
                        )
                    );
                }
            }
        }


        return $this->_redirectToIndex();
    }
}