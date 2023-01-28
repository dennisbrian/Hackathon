<?php

use yii\db\Migration;

/**
 * Class m230128_091053_add_is_vip_user_table
 */
class m230128_091053_add_is_vip_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "is_vip", "tinyint(1) default 0 after `is_suspend`");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'is_vip');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230128_091053_add_is_vip_user_table cannot be reverted.\n";

        return false;
    }
    */
}
