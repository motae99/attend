<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sem_id
 * @property string $details
 * @property Attendance[] $attendances 
 * @property Semester $sem
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sem_id'], 'required'],
            [['sem_id'], 'integer'],
            [['details'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['sem_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['sem_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sem_id' => 'Sem ID',
            'details' => 'Details',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getAttendances() 
    { 
       return $this->hasMany(Attendance::className(), ['stu_id' => 'id']); 
    } 
 
    /** 
     * @return \yii\db\ActiveQuery 
    */ 
    public function getSem()
    {
        return $this->hasOne(Semester::className(), ['id' => 'sem_id']);
    }
}
