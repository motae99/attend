<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semester".
 *
 * @property integer $id
 * @property integer $course_id
 * @property string $sem_name
 * @property integer $no_of_subjects
 * @property string $start_date
 * @property string $end_date
 *
 * @property Course $course
 * @property Student[] $students
 * @property Subjects[] $subjects
 */
class Semester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'sem_name', 'no_of_subjects', 'start_date', 'end_date'], 'required'],
            [['course_id', 'no_of_subjects'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['sem_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'sem_name' => 'Sem Name',
            'no_of_subjects' => 'No Of Subjects',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['sem_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subjects::className(), ['sem_id' => 'id']);
    }
}
