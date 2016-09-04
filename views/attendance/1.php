<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Calender;
use app\models\Attendance;
use app\models\Student;


/* @var $this yii\web\View */
/* @var $model app\models\Attendance */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
$subject_id = 2;
$start = "2016-07-01";
$end = "2016-08-01";
$presents = array();
$all = array();
$students = Student::find()->where(['sem_id'=> 3])->all();

?>
<div class="table-responsive">
<table class="table invoice-items">
    <thead>
	    <tr class="h4 text-dark">
	    	<th>
				Students
			</th>
			<?php 
	    		foreach ($students as $ss => $s) {
	    	?>
			<td>
    			<?=$s['id']?>
    		</td>
<?php
$dates = Calender::find()->where(['sub_id'=> $subject_id])->all();
foreach ($dates as $date => $value) {
	$att = Attendance::find()->where(['sub_id'=> $subject_id, 'time_table_id' => $value['id']])->all();
	foreach ($att as $key => $k) {
		$stu = $k['stu_id'];
		$presents[]['student'] = $stu;
		$presents[]['date'] = $value['date'];
	}
	// $presents['date']= $value['date'];
?>
			
			<th class="text-center text-semibold">
	    	<?= $value['date']?>	
	    	</th>



<?php
}
?>

	    	
	    </tr>
	    	<?php 
	    		foreach ($students as $ss => $s) {
	    	?>
	    <tr>
			<td>
    			<?=$s['id']?>
    		</td>
    	</tr>
	    	<?php		
	    		}
	    	?>
    </tbody>
</table>
</div>

<?php 
$attended = (new \yii\db\Query())
		    // ->select(['sm.stu_master_id', 'stu_unique_id', "CONCAT(si.stu_first_name, ' ', si.stu_last_name) AS 'stu_name'", 'cs.course_name', 'b.batch_name', 'DATE_FORMAT(sm.created_at, "%d-%m-%Y") AS cDate']) 
		    ->select(['a.stu_id', 'a.time_table_id', 'c.date']) 
		    ->from('attendance a')
		    ->join('JOIN', 'student s', 's.id = a.stu_id')
		    ->join('JOIN', 'calender c', 'c.id = a.time_table_id')
		    // ->join('JOIN', 'batches b', 'b.batch_id = sm.stu_master_batch_id')
		    ->where(['a.sub_id' => '2'])
		    // ->orderBy('stu_master_id DESC')
		    // ->limit(10)
		    ->all();
		    var_dump($attended);
?>