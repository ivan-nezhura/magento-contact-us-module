<?php
namespace Nezhura\ContactUs\Model\ResourceModel;

use Nezhura\ContactUs\Config;

/**
 * Class ContactUs
 * @package Nezhura\ContactUs\Model\ResourceModel
 */
class ContactUs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init(Config::TABLE_NAME, 'contact_us_id');
    }
}