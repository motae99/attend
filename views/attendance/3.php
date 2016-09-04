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
					    	$table = $class->timeTable;
// DUBLICATION ON THE SAME date AND SAME time_table_id WITH THE SAME stu_id will scrow up the table
							if ($table->id = $date->id && $class->stu_id == $s_id && $table->date == $date->date) {
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
