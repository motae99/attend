<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "engineers".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $phone_no
 * @property string $name
 * @property integer $service_cost
 * @property string $task
 * @property string $created_at
 *
 * @property EPayment[] $ePayments
 * @property Customer $customer
 */
class Engineers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'engineers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'phone_no', 'name', 'service_cost', 'task'], 'required'],
            [['customer_id', 'phone_no', 'service_cost'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'task'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'phone_no' => 'Phone No',
            'name' => 'Name',
            'service_cost' => 'Service Cost',
            'task' => 'Task',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEPayments()
    {
        return $this->hasMany(EPayment::className(), ['engineer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
