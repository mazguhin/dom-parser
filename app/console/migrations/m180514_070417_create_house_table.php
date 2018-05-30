<?php

use yii\db\Migration;

/**
 * Handles the creation of table `house`.
 */
class m180514_070417_create_house_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('house', [
            'id' => $this->primaryKey()->unsigned(),
            'address' => $this->string()->defaultValue('')->comment('Адрес'),
            'year' => $this->integer()->defaultValue(0)->comment('Год постройки'),
            'floors' => $this->integer()->defaultValue(0)->comment('Количество этажей'),
            'type' => $this->string()->defaultValue('')->comment('Тип дома'),
            'quarters' => $this->integer()->defaultValue(0)->comment('Жилых помещений'),
            'series' => $this->string()->defaultValue('')->comment('Серия, тип конструкции'),
            'floor_type' => $this->string()->defaultValue('')->comment('Тип перекрытий'),
            'walls_material' => $this->string()->defaultValue('')->comment('Материал несущих стен'),
            'emergency' => "tinyint(1) UNSIGNED DEFAULT 0 COMMENT 'Признан аварийным'",
            'cadastral_number' => $this->string()->defaultValue('')->comment('Кадастровый номер'),
            'url' => $this->string()->defaultValue('')->comment('URL'),
            'square' => $this->string()->defaultValue('')->comment('Площадь'),

            'region_id' => $this->integer()->unsigned()->comment('Регион'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
        ]);


        $this->createIndex('house-address', 'house', 'address');
        $this->createIndex('house-emergency', 'house', 'emergency');
        $this->createIndex('house-url', 'house', 'url', true);
        $this->createIndex('house-cadastral_number', 'house', 'cadastral_number');

        $this->createIndex('house-region_id', 'house', 'region_id');
        $this->addForeignKey('house-region', 'house','region_id','region', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('house-address', 'house');
        $this->dropIndex('house-emergency', 'house');
        $this->dropIndex('house-url', 'house');
        $this->dropIndex('house-cadastral_number', 'house');

        $this->dropForeignKey('house-region', 'house');
        $this->dropIndex('house-region_id', 'house');
        $this->dropTable('house');
    }
}
