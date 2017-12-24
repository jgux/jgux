<?php

use yii\db\Migration;

/**
 * Handles the creation of table `luzhengyou`.
 */
class m171218_143440_create_luzhengyou_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('luzhengyou', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->comment("名称")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('luzhengyou');
    }
}
