<?php
/**
 * Created by PhpStorm.
 * User: nezhura
 * Date: 11/13/17
 * Time: 2:43 PM
 */

namespace Nezhura\ContactUs\Plugin;

use Magento\Contact\Controller\Index\Post;

/**
 * Class ContactUsPlugin
 *
 * Intercepting contact form submission
 *
 * @package Nezhura\ContactUs\Plugin
 */
class ContactUsPlugin extends Post
{
    /**
     * handle contact us form submission (sends mail and saves data to DB)
     */
    public function aroundExecute()
    {
        return parent::execute(); // TODO: Change the autogenerated stub
    }
}
