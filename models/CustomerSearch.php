<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phone_no', 'Maintenance_cost', 'service_cost', 'spare_cost', 'total_cost'], 'integer'],
            [['full_name', 'car_type', 'plate_no', 'created_at', 'updated_at', 'date'], 'safe'],
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
        $query = Customer::find();

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
            'phone_no' => $this->phone_no,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'Maintenance_cost' => $this->Maintenance_cost,
            'service_cost' => $this->service_cost,
            'spare_cost' => $this->spare_cost,
            'total_cost' => $this->total_cost,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'car_type', $this->car_type])
            ->andFilterWhere(['like', 'plate_no', $this->plate_no]);

        return $dataProvider;
    }
}
