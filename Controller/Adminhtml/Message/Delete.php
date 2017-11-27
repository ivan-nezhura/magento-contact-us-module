<?php
namespace Nezhura\ContactUs\Controller\Adminhtml\Message;

use Nezhura\ContactUs\Controller\Adminhtml\Message as BaseAction;


/**
 * Class Delete
 * @package Nezhura\ContactUs\Controller\Adminhtml\Post
 */
class Delete extends BaseAction
{
    /**
     * handles deleting message record
     *
     * @inheritdoc
     */
    public function execute()
    {
        $message = $this->_getMessage();

        try{
            $this->_resourceMessageFactory
                ->create()
                ->delete($message);
        } catch (\Exception $e) {
            $this->messageManager
                ->addErrorMessage(
                    __(
                        'Error was occurred: %1. Message is not deleted.',
                        $e->getMessage()
                    )
                );
            return $this->_redirect(
                'contact_us/message/reply',
                ['id' => $message->getId()]
            );
        }

        $this->messageManager
            ->addSuccessMessage(
                __('Message was deleted.')
            );

        return $this->_redirectToIndex();
    }
}