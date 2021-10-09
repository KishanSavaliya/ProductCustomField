<?php

namespace SK\DeliveryInstruction\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.1') < 0) {
            $setup->startSetup();
            $connection = $setup->getConnection();
            $connection->addColumn(
                $setup->getTable('quote_item'),
                'delivery_instruction',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Delivery Instruction'
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_order_item'),
                'delivery_instruction',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Delivery Instruction'
                ]
            );
            $setup->endSetup();
        }
    }
}
