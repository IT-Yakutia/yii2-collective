<?php

use yii\db\Migration;

/**
 * Class m200823_195321_add_collective
 */
class m200823_195321_add_collective extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('collective', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'photo' => $this->string()->notNull(),
            'post' => $this->string(), // не position потому что position будет использоваться в nested
            'email' => $this->string(),
            'phone' => $this->string(),
            'vk_link' => $this->string(),
            'fb_link' => $this->string(),
            'inst_link' => $this->string(),

            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0),

            'sort' => $this->integer(),

            'is_publish' => $this->boolean(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('collective');
    }
}
