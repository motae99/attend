<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Spare;

/**
 * SpareSearch represents the model behind the search form about `app\models\Spare`.
 */
class SpareSearch extends Spare
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'price'], 'integer'],
            [['spare_name', 'part_number', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Spare::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'price' => $this->price,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'spare_name', $this->spare_name])
            ->andFilterWhere(['like', 'part_number', $this->part_number]);

        return $dataProvider;
    }
}
