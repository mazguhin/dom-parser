<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name Название
 * @property string $url URL
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'url' => 'URL',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\queries\RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\queries\RegionQuery(get_called_class());
    }
}
