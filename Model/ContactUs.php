<?php
namespace Nezhura\ContactUs\Model;

/**
 * Class ContactUs
 * @package Nezhura\ContactUs\Model
 */
class ContactUs extends \Magento\Framework\Model\AbstractModel
{
    protected $_cacheTag = 'nezhura_contact_us';

//    protected $_eventPrefix = 'nezhura_contact_us';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('Nezhura\ContactUs\Model\ResourceModel\ContactUs');
    }

    /*public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }*/

    /*public function getDefaultValues()
    {
        $values = [];

        return $values;
    }*/
}