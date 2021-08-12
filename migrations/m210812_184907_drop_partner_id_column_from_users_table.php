<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%users}}`.
 */
class m210812_184907_drop_partner_id_column_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'partner_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%users}}', 'partner_id', $this->integer());
    }
}
