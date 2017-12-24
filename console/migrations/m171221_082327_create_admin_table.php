<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m171221_082327_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment("姓名"),
            'age'=>$this->string()->notNull()->comment("年龄"),
            'sex'=>$this->string()->notNull()->comment("性别"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
