<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movies}}`.
 */
class m230128_013732_create_movie_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%movies}}', [
            'id'            => $this->primaryKey(),
            'movie_name'    => "string",
            'genre'         => "string",
            'cover'         => "string",
            'path'          => "string",
            "created_at"    => "timestamp default CURRENT_TIMESTAMP",
            "updated_at"    => "timestamp null on update CURRENT_TIMESTAMP",
            "is_delete"     => "tinyint(1) null default 0",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%movies}}');
    }
}
