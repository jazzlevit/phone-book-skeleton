<?php

use yii\db\Migration;

class m130524_201444_create_contacts extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey()->unsigned(),
            'first_name' => $this->string(64)->notNull(),
            'last_name' => $this->string(64)->notNull(),
        ], $tableOptions);


        $this->createTable('{{%phone}}', [
            'id' => $this->primaryKey()->unsigned(),
            'contact_id' => $this->integer()->notNull()->unsigned(),
            'phone' => $this->string(32)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_contact_id', '{{%phone}}', 'contact_id');
    }

    public function down()
    {
        $this->dropTable('{{%phone}}');

        $this->dropTable('{{%contact}}');
    }
}
