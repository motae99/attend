<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Calender;
use app\models\Attendance;
use app\models\Student;

?>

<?php 
$subject_id = 2;
$start = "2016-07-01";
$end = "2016-08-01";
$presents = array();
$all = array();
$students = Student::find()->where(['sem_id'=> 3])->all();
$dates = Calender::find()->where(['sub_id'=> $subject_id])->all();
$no = Calender::find()->where(['sub_id'=> $subject_id])->count();
echo $no;
?>

<div class="table-responsive">
	<table class="table invoice-items">
		<tr>
			    	<th>
						Students
					</th>


			<?php 
				foreach ($dates as $date => $k) {
					echo "<th>";
					echo $k['date'];	
					echo "</th>";
					
				}
			?>
		</tr>
		<tbody>
			<tr>
			<?php 
			

				foreach ($students as $student ) {
					echo "<tr>";
					$s_id = $student->id;
					echo "<td>";
					echo $s_id;
					echo "</td>";
					$classes = $student->attendances ;
					foreach ($dates as $date ) {
						// echo "<td>";
						// echo $date->date;
						// echo "</td>";
					    foreach ($classes as $class) {
							if ($class->time_table_id = $date->id && $class->stu_id == $s_id) {
								echo "<td>";
								echo "yes";
								echo "</td>";
							}else{
								echo "<td>";
								echo "no";
								echo "</td>";
							}
					    }
						
				}
				echo "</tr>";
				
				}
			
			?>
				
			</tr>
			
		</tbody>
				
	</table>
</div>

<div>
	<table>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
		</tr>
		<tr>
			<td>v</td>
			<td>v</td>
			<td>v</td>
			<td>v</td>
			<td>v</td>
		</tr>
	</table>
</div>

<?php 
// $attended = (new \yii\db\Query())
// 		    // ->select(['sm.stu_master_id', 'stu_unique_id', "CONCAT(si.stu_first_name, ' ', si.stu_last_name) AS 'stu_name'", 'cs.course_name', 'b.batch_name', 'DATE_FORMAT(sm.created_at, "%d-%m-%Y") AS cDate']) 
// 		    ->select(['a.stu_id', 'a.time_table_id', 'c.date']) 
// 		    ->from('attendance a ')
// 		    ->join('JOIN', 'student s', 's.id = a.stu_id')
// 		    ->join('JOIN', 'calender c', 'c.id = a.time_table_id')
// 		    // ->join('JOIN', 'batches b', 'b.batch_id = sm.stu_master_batch_id')
// 		    ->where(['a.sub_id' => '2'])
// 		    // ->orderBy('stu_master_id DESC')
// 		    // ->limit(10)
// 		    ->all();
// 		    var_dump($attended);

// 		    SELECT `attendance.stu_id`, `attendance.time_table_id`, `calender.date`
// 		    FROM `attendance`
// 		     LEFT JOIN `attend`.`student` ON `student.id = attendance.stu_id`
// 		    WHERE(`attendance.sub_id` = 2)

// 		    JOIN `calender`, `calender.id = attendance.time_table_id`
// ////////////ok/////////////
// SELECT *
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// ////////////////////////////	

// /////ok////////////
// SELECT *
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// //////////////////

// ////////////ok/////////////
// SELECT *
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// LEFT JOIN `attend`.`calender` ON `attendance`.`time_table_id` = `calender`.`id`
// ////////////////////////////

// ////////////ok/////////////
// SELECT *
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// LEFT JOIN `attend`.`calender` ON `attendance`.`time_table_id` = `calender`.`id`
// WHERE (`attendance`.`sub_id` = 5)
// ////////////////////////////

// ////////////ok/////////////
// SELECT `student`.`id`, `calender`.`date`
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// LEFT JOIN `attend`.`calender` ON `attendance`.`time_table_id` = `calender`.`id`
// ////////////////////////////

// ////////////ok/////////////
// SELECT `student`.*, `calender`.`date`,`calender`.`sub_id`
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// LEFT JOIN `attend`.`calender` ON `attendance`.`time_table_id` = `calender`.`id`
// //WHERE (`attendance`.`sub_id` = 2) this is filtering condition
// ////////////////////////////

// ////////////ok/////////////
// SELECT *
// FROM `attendance` 
// LEFT JOIN `attend`.`student` ON `attendance`.`stu_id` = `student`.`id`
// LEFT JOIN `attend`.`calender` ON `attendance`.`time_table_id` = `calender`.`id`
// //WHERE (`attendance`.`sub_id` = 2) this is filtering condition
// ////////////////////////////

?>
