<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property int $id
 * @property string $address Адрес
 * @property int $year Год постройки
 * @property int $floors Количество этажей
 * @property string $type Тип дома
 * @property int $quarters Жилых помещений
 * @property string $series Серия, тип конструкции
 * @property string $floor_type Тип перекрытий
 * @property string $walls_material Материал несущих стен
 * @property int $emergency Признан аварийным
 * @property string $cadastral_number Кадастровый номер
 * @property string $url URL
 * @property string $square Площадь
 * @property int $region_id Регион
 * @property int $updated_at Дата обновления
 *
 * @property Region $region
 */
class House extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'floors', 'quarters', 'emergency', 'region_id', 'updated_at'], 'integer'],
            [['address', 'type', 'series', 'floor_type', 'walls_material', 'cadastral_number', 'url', 'square'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Адрес',
            'year' => 'Год постройки',
            'floors' => 'Количество этажей',
            'type' => 'Тип дома',
            'quarters' => 'Жилых помещений',
            'series' => 'Серия, тип конструкции',
            'floor_type' => 'Тип перекрытий',
            'walls_material' => 'Материал несущих стен',
            'emergency' => 'Признан аварийным',
            'cadastral_number' => 'Кадастровый номер',
            'url' => 'URL',
            'square' => 'Площадь',
            'region_id' => 'Регион',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\queries\HouseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\queries\HouseQuery(get_called_class());
    }
}
