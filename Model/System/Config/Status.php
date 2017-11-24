<?php
namespace Nezhura\ContactUs\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;
use Nezhura\ContactUs\Model\Message;

/**
 * Class Status
 * @package Nezhura\ContactUs\Model\System\Config
 */
class Status implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            Message::STATUS_NEW => __('New'),
            Message::STATUS_PROCESSED => __('Processed')
        ];

        return $options;
    }
}