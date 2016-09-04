<?php 
// var_dump($dates);
// var_dump($presents);
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

// $dates = Calender::find()
// 			->where(['between', 'date', $start , $end])
			// ->all();
?>