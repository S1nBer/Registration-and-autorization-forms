<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%menu}}`.
 */
class m210812_084650_add_name_column_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_tree}}', 'tree', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_tree}}', 'tree');
    }
}
