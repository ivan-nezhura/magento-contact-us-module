<?php
namespace Nezhura\ContactUs\Setup;

use Nezhura\ContactUs\Config;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable(Config::TABLE_NAME))
            ->addColumn(
                Config::ID_FIELD_NAME,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                128,
                ['nullable' => false],
                'Email'
            )
            ->addColumn(
                'telephone',
                Table::TYPE_TEXT,
                25,
                [],
                'Phone number'
            )
            ->addColumn(
                'comment',
                Table::TYPE_TEXT,
                Table::DEFAULT_TEXT_SIZE,
                ['nullable' => false],
                'Message text'
            )
            ->addColumn(
                'created',
                Table::TYPE_TIMESTAMP,
                null,
                [],
                'Form submitted at'
            )
            ->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                'modified',
                Table::TYPE_TIMESTAMP,
                null,
                [],
                'Application modified at'
            )
            ->setComment('ContactUs form');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}