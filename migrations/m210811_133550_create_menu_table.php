<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m210811_133550_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_tree}}', [
            'id'      => $this->primaryKey(),
            //'tree' => $this->integer()->notNull(),
            'lft'     => $this->integer()->notNull(),
            'rgt'     => $this->integer()->notNull(),
            'depth'   => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_user_tree_user_id', 'user_tree', 'user_id',
            'users', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_tree}}');
    }
}
