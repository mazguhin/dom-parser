<?php

use yii\db\Migration;

/**
 * Handles the creation of table `home`.
 */
class m180514_070418_create_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('home', [
            'id' => $this->primaryKey()->unsigned(),
            'identifier' => $this->string()->defaultValue('')->comment('Идентификатор'),
            'shortname_region' => $this->string()->defaultValue('')->comment('Тип региона'),
            'formalname_region' => $this->string()->defaultValue('')->comment('Наименование региона'),
            'shortname_area' => $this->string()->defaultValue('')->comment('Тип района'),
            'formalname_area' => $this->string()->defaultValue('')->comment('Наименование района'),
            'shortname_city' => $this->string()->defaultValue('')->comment('Тип города'),
            'formalname_city' => $this->string()->defaultValue('')->comment('Наименование города'),
            'shortname_street' => $this->string()->defaultValue('')->comment('Тип улицы'),
            'formalname_street' => $this->string()->defaultValue('')->comment('Наименование улицы'),
            'home_number' => $this->string()->defaultValue('')->comment('Номер дома'),
            'building' => $this->string()->defaultValue('')->comment('Здание'),
            'block' => $this->string()->defaultValue('')->comment('Блок'),
            'letter' => $this->string()->defaultValue('')->comment('Буква'),
            'address' => $this->string()->defaultValue('')->comment('Адрес'),
            'built_year' => $this->string()->defaultValue('')->comment('Год постройки'),
            'project_type' => $this->string()->defaultValue('')->comment('Тип проекта'),
            'home_type' => $this->string()->defaultValue('')->comment('Тип дома'),
            'is_alarm' => $this->string()->defaultValue('')->comment('Аварийное'),
            'area_total' => $this->string()->defaultValue('')->comment('Общая площадь'),
            'area_residential' => $this->string()->defaultValue('')->comment('Жилая площадь'),
            'foundation_type' => $this->string()->defaultValue('')->comment('Тип фундамента'),
            'floor_type' => $this->string()->defaultValue('')->comment('Тип перекрытий'),
            'wall_material' => $this->string()->defaultValue('')->comment('Материал несущих стен'),
            'region_id' => $this->integer()->unsigned()->comment('Регион'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
        ]);


        $this->createIndex('home-address', 'home', 'address');
        $this->createIndex('home-project_type', 'home', 'project_type');
        $this->createIndex('home-identifier', 'home', 'identifier', true);

        $this->createIndex('home-region_id', 'home', 'region_id');
        $this->addForeignKey('home-region', 'home','region_id','region', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('home-address', 'home');
        $this->dropIndex('home-project_type', 'home');
        $this->dropIndex('home-identifier', 'home');

        $this->dropForeignKey('home-region', 'home');
        $this->dropIndex('home-region_id', 'home');
        $this->dropTable('home');
    }
}
