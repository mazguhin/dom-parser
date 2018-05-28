<?php

namespace common\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\entities\House;

/**
 * HouseSearch represents the model behind the search form of `common\entities\House`.
 */
class HouseSearch extends House
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year', 'floors', 'quarters', 'emergency', 'region_id', 'updated_at'], 'integer'],
            [['address', 'type', 'series', 'floor_type', 'walls_material', 'cadastral_number', 'url', 'square'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = House::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
            'floors' => $this->floors,
            'quarters' => $this->quarters,
            'emergency' => $this->emergency,
            'region_id' => $this->region_id,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'series', $this->series])
            ->andFilterWhere(['like', 'floor_type', $this->floor_type])
            ->andFilterWhere(['like', 'walls_material', $this->walls_material])
            ->andFilterWhere(['like', 'cadastral_number', $this->cadastral_number])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'square', $this->square]);

        return $dataProvider;
    }
}
