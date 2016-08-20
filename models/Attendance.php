<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property integer $id
 * @property integer $sub_id
 * @property integer $stu_id
 * @property integer $status
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
            [['sub_id', 'stu_id', 'status'], 'required'],
            [['sub_id', 'stu_id', 'status'], 'integer'],
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
}
