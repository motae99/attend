<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $full_name
 * @property integer $phone_no
 * @property string $car_type
 * @property string $plate_no
 * @property string $created_at
 * @property string $updated_at
 * @property integer $Maintenance_cost
 * @property integer $service_cost
 * @property integer $spare_cost
 * @property integer $total_cost
 * @property string $date
 *
 * @property CPayment[] $cPayments
 * @property Engineers[] $engineers
 * @property ReplacedSpare[] $replacedSpares
 * @property Spare[] $spares
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'phone_no', 'car_type', 'plate_no'], 'required'],
            [['phone_no', 'Maintenance_cost', 'service_cost', 'spare_cost', 'total_cost'], 'integer'],
            [['created_at', 'updated_at', 'date'], 'safe'],
            [['full_name'], 'string', 'max' => 50],
            [['car_type', 'plate_no'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'phone_no' => 'Phone No',
            'car_type' => 'Car Type',
            'plate_no' => 'Plate No',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'Maintenance_cost' => 'Maintenance Cost',
            'service_cost' => 'Service Cost',
            'spare_cost' => 'Spare Cost',
            'total_cost' => 'Total Cost',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCPayments()
    {
        return $this->hasMany(CPayment::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEngineers()
    {
        return $this->hasMany(Engineers::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplacedSpares()
    {
        return $this->hasMany(ReplacedSpare::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpares()
    {
        return $this->hasMany(Spare::className(), ['customer_id' => 'id']);
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
