<?php

use yii\db\Migration;

/**
 * Handles the creation of table `region`.
 */
class m180511_122948_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('region', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->comment('Название'),
            'url' => $this->string()->comment('URL'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('region');
    }
}
