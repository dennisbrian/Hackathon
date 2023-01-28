<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220825_044720_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'first_name'           => 'varchar(100)',
            'middle_name'          => 'varchar(100)',
            'last_name'            => 'varchar(100)',
            'email'                => 'varchar(100)',
            'dob'                  => 'date',

            'phone_code'           => 'varchar(100)',
            'phone_number'         => 'varchar(100)',

            'address'              => 'varchar(100)',
            'city'                 => 'varchar(100)',
            'state'                => 'varchar(100)',
            'postcode'             => 'varchar(100)',
            'country_code'         => 'varchar(100)',
            'country_name'         => 'varchar(100)',

            'password'             => 'varchar(255)',
            'password_key'         => 'varchar(255)',
            'access_token'         => 'varchar(255)',
            'role'                 => 'varchar(100)',

            'is_signup_email_sent' => "tinyint(1) null default 0",
            'is_suspend'           => 'tinyint(1) not null default 0',

            'created_at'           => "timestamp default CURRENT_TIMESTAMP",
            "updated_at"           => "timestamp null on update CURRENT_TIMESTAMP",
            "is_delete"            => "tinyint(1) null default 0",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
