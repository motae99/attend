<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Calender;
use app\models\User;


/* @var $this yii\web\View */
/* @var $model app\models\Attendance */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
$subject_id = 73;
$start = "2016-07-01";
$end = "2016-08-01";
// $timeTable = Calender::find()->where(['sub_id'=> $subject_id])->all();
// $timeTable = Calender::find()->where(['between', 'date', $start , $end])->all();
// $subQuery = (new \yii\db\Query())
// 	->select('*')
// 	->from('users')
// 	// ->where(['between', 'date', $start , $end])
// 	// ->andWhere(['sub_id'=> $subject_id])
// 	->all();
// // // $query->where(['sub_id'=> $subject_id])->all();
// // var_dump($subQuery);
// 	foreach ($subQuery as $key => $value) {
// 		echo $value['id']. " ".$value['uid']." ".$value['name']."<br>";
// 	}

/*$status = 10;
$search = 'yii';
$query->where(['status' => $status]);
if (!empty($search)) {
$query->andWhere(['like', 'title', $search]);
}

In case $search isn’t empty the following SQL will be generated:
WHERE (‘status‘ = 10) AND (‘title‘ LIKE ’%yii%’)*/
// $all = User::find()_>where(['status' => $status])->all();
// var_dump($all);

$dates = Calender::find()
			->where(['between', 'date', $start , $end])
			->all();
?>