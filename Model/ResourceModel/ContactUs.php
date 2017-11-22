<?php
namespace Nezhura\ContactUs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Nezhura\ContactUs\Config;
use Nezhura\ContactUs\Model\ContactUs as BaseModel;

class ContactUs extends AbstractDb
{
    /**
     * Date model
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * ContactUs constructor.
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param null $connectionName
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        $this->_date = $date;

        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Config::TABLE_NAME, Config::ID_FIELD_NAME);
    }

    /**
     * @inheritdoc
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setModified($this->_date->timestamp());
        if ($object->isObjectNew()) {
            $object->setCreated($this->_date->timestamp());
            $object->setStatus(BaseModel::STATUS_NEW);
        }
        return parent::_beforeSave($object);
    }
}