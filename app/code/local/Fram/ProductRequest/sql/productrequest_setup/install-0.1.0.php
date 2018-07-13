<?php

$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$connection->dropTable($installer->getTable('productrequest/request'));

$table = $connection->newTable($installer->getTable('productrequest/request'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary' => true,
        'unsigned' => true,
        'auto_increment' => true,
        'nullable' => false
    ), 'Request Id')
    ->addColumn('customer_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Customer Name')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Customer Email')
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false
    ), 'Comment')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true
    ), 'Image')
    ->addColumn('is_approved', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => true,
        'default'=>-1
    ), 'Is Approved')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => false
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true
    ), 'Updated At');

$connection->createTable($table);

$installer->endSetup();