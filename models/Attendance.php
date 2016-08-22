<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property integer $id
 * @property integer $sub_id
 * @property integer $stu_id
 * @property integer $time_table_id
 * @property integer $status
 *
 * @property Student $stu
 * @property Subjects $sub
 * @property Calender $timeTable
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_id', 'stu_id', 'time_table_id', 'status'], 'required'],
            [['sub_id', 'stu_id', 'time_table_id', 'status'], 'integer'],
            [['stu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['stu_id' => 'id']],
            [['sub_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['sub_id' => 'id']],
            [['time_table_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calender::className(), 'targetAttribute' => ['time_table_id' => 'id']],
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
            'stu_id' => 'Stu ID',
            'time_table_id' => 'Time Table ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStu()
    {
        return $this->hasOne(Student::className(), ['id' => 'stu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSub()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'sub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeTable()
    {
        return $this->hasOne(Calender::className(), ['id' => 'time_table_id']);
    }
}
