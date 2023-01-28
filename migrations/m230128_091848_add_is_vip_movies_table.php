<?php

use yii\db\Migration;

/**
 * Class m230128_091848_add_is_vip_movies_table
 */
class m230128_091848_add_is_vip_movies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("movies", "is_vip", "tinyint(1) default 0 after `is_delete`");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('movies', 'is_vip');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230128_091848_add_is_vip_movies_table cannot be reverted.\n";

        return false;
    }
    */
}
