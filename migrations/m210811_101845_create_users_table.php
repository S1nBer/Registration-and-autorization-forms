<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210811_101845_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id'         => $this->primaryKey(),
            'email'      => $this->string(255)->notNull(),
            'partner_id' => $this->integer(10)->notNull(),
            'date'       => $this->date()->notNull(),
        ]);

        $this->insert('users', [
            'email'      => 'sin_ber@bk.ru',
            'partner_id' => '1111111111',
            'date'       => '2021-08-11',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['id => 1']);
        $this->dropTable('users');
    }
}
