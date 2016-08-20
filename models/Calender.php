<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calender".
 *
 * @property integer $id
 * @property integer $sub_id
 * @property string $day
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 *
 * @property Subjects $sub
 */
class Calender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_id', 'day','date', 'start_time', 'end_time'], 'required'],
            [['sub_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['day'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sub_id' => 'Sub ID',
            'day' => 'Day',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSub()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'sub_id']);
    }
}
