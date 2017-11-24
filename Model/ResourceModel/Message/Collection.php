<?php
namespace Nezhura\ContactUs\Model\ResourceModel\Message;

use Nezhura\ContactUs\Config;

/**
 * Class Collection
 * @package Nezhura\ContactUs\Model\ResourceModel\Message
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = Config::ID_FIELD_NAME;

    /**
     * @var string
     */
    protected $_eventPrefix = 'nezhura_contact_us_message_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'message_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Nezhura\ContactUs\Model\Message', 'Nezhura\ContactUs\Model\ResourceModel\Message');
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Zend_Db_Select::GROUP);
        return $countSelect;
    }
    /**
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    protected function _toOptionArray($valueField = 'contact_us_id', $labelField = 'name', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}