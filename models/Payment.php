<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $engineer_id
 * @property integer $paid_amount
 * @property integer $total_paid
 * @property string $created_at
 *
 * @property Engineers $engineer
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['engineer_id', 'paid_amount', 'total_paid'], 'required'],
            [['engineer_id', 'paid_amount', 'total_paid'], 'integer'],
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
            'engineer_id' => 'Engineer ID',
            'paid_amount' => 'Paid Amount',
            'total_paid' => 'Total Paid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEngineer()
    {
        return $this->hasOne(Engineers::className(), ['id' => 'engineer_id']);
    }
}
