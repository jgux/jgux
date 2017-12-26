<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m171226_032434_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'tree'=>$this->integer()->notNull()->comment("树"),
            'lft'=>$this->integer()->notNull()->comment('左值'),
            'rgt'=>$this->integer()->notNull()->comment('右值'),
            'depth'=>$this->integer()->notNull()->comment('深度'),
            'name'=>$this->string()->notNull()->comment('名称'),
            'parent_id'=>$this->integer()->notNull()->defaultValue(0)->comment('父类ID'),
            'intro'=>$this->string()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
