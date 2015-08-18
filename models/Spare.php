<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "spare".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $spare_name
 * @property string $part_number
 * @property integer $price
 * @property string $created_at
 *
 * @property Customer $customer
 */
class Spare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spare';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'spare_name', 'part_number'], 'required'],
            [['customer_id', 'price'], 'integer'],
            [['created_at'], 'safe'],
            [['spare_name', 'part_number'], 'string', 'max' => 45]
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
            'spare_name' => 'Spare Name',
            'part_number' => 'Part Number',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
