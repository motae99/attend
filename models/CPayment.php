<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_payment".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $paid
 * @property integer $remaining
 * @property string $created_at
 *
 * @property Customer $customer
 */
class CPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'paid', 'remaining'], 'required'],
            [['customer_id', 'paid', 'remaining'], 'integer'],
            [['created_at'], 'safe']
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
            'paid' => 'Paid',
            'remaining' => 'Remaining',
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
