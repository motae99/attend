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
 * @property string $status
 *
 * @property Attendance[] $attendances
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
            [['sub_id', 'day', 'date', 'start_time', 'end_time'], 'required'],
            [['sub_id'], 'integer'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['status'], 'string'],
            [['day'], 'string', 'max' => 45],
            [['sub_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['sub_id' => 'id']],
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
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::className(), ['time_table_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSub()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'sub_id']);
    }
}
