Contact Us Module - for Magento 2
===============================
Saves submitted native 'Contact Us' form to DB.
Allows to make response from admin part.

Installation
-----------
- Copy following data to relevant sections of your composer.json
    ```
    {
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/ivan-nezhura/magento-contact-us-module.git"
            }
        ],
        "require": {
            "nezhura/module-contact-us": "dev-master"
        }
    }
    ```
    and run
    ```
    composer update
    ```
    **OR**
    
    copy source code into your project
- Run
    ```
    bin/magento setup:upgrade
    bin/magento cache:clean
    ```
