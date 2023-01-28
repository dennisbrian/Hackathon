<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_role}}`.
 */
class m220825_044855_create_user_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_role}}', [
            "name"          => "varchar(100)",
            "label"         => "varchar(100)",
            "description"   => "varchar(255)",
            "created_at"    => "timestamp default CURRENT_TIMESTAMP",
            "updated_at"    => "timestamp null on update CURRENT_TIMESTAMP",
            "is_delete"     => "tinyint(1) null default 0",
            "primary key (`name`)",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_role}}');
    }
}
