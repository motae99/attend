<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property integer $sem_id
 * @property string $sub_name
 * @property integer $no_of_lect
 *
 * @property Calender[] $calenders
 * @property Semester $sem
 */
class Subjects extends \yii\db\ActiveRecord
{   
    public $course;
    public $dateOfTheWeek;
    public $sat_start_time; 
    public $sat_end_time;
    public $sun_start_time; 
    public $sun_end_time;
    public $mon_start_time; 
    public $mon_end_time;
    public $tue_start_time; 
    public $tue_end_time;
    public $wen_start_time; 
    public $wen_end_time;
    public $the_start_time; 
    public $the_end_time;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sem_id', 'sub_name', 'color_class'], 'required'],
            [['sem_id', 'no_of_lect'], 'integer'],
            [['sub_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sem_id' => 'Sem',
            'sub_name' => 'Subject Name',
            'no_of_lect' => 'No Of Lect',
            'color_class' => 'Subject Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalenders()
    {
        return $this->hasMany(Calender::className(), ['sub_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSem()
    {
        return $this->hasOne(Semester::className(), ['id' => 'sem_id']);
    }
}
