<?php
namespace Nezhura\ContactUs\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Message
 * @package Nezhura\ContactUs\Model
 */
class Message extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'nezhura_contact_us_form_data';
    const STATUS_NEW = 1;


    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('Nezhura\ContactUs\Model\ResourceModel\Message');
    }

    /**
     * @inheritdoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}