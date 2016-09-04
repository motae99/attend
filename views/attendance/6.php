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
$day = strtotime($end);
// echo date($end, 'Y-mm-dd');
// echo date('d', $day);
$students = Student::find()->where(['sem_id'=> 3])->all();
$dates = Calender::find()->where(['sub_id'=> $subject_id])->all();
foreach ($dates as $date ) {
	
}
$no = Calender::find()->where(['sub_id'=> $subject_id])->count();
// echo $no;
?>
<div class="box">
	<div class="table-responsive">
		<table class="table invoice-items">
			<thead>
				<tr class="h5 text-dark">
					    	<th class="text-center" >
								Students
							</th>


					<?php 
						foreach ($dates as $date => $k) {
								$day = strtotime($k['date']);
								// echo date('Y-m', $day);	
								echo "<th class='text-center'>";
								echo date('m/d', $day);	
								echo "</th>";
							
						}
					?>
				</tr>
			</thead>
			<tbody>
				<tr> 
				<?php 
				foreach ($students as $student ) {
						echo "<tr>";
						$s_id = $student->id;
						// $student = Student::find()->where(['id' => $s_id])->one();
						echo "<td class='text-center'>";
						echo $student->id;
						echo "</td>";
					foreach ($dates as $date ) {
						if ($date->status == 'done') {
							$classes = Attendance::find()->where(['stu_id' => $s_id, 'time_table_id' => $date->id])->all();
							if($classes){
							    foreach ($classes as $class) {
									if ($class->timeTable->date == $date->date) {
										echo "<td class='text-center'>";
										echo "<i class='fa fa-2x fa-check bg-green'></i>";
										echo "</td>";
									}
							    }
							}else{
								echo "<td class='text-center'>";
								echo "<i class='fa fa-2x fa-remove bg-red'></i>";
								echo "</td>";

							}
						}elseif($date->date < date('Y-m-d') && $date->status == 'schedualed'){
							echo "<td class='text-center'>";
							echo "<i class='fa fa-2x fa-minus bg-orange'></i>";
							echo "</td>";
						}elseif($date->status == 'schedualed'){
							echo "<td class='text-center'>";
							echo "<i class='fa fa-2x fa-plus bg-aqua'></i>";
							echo "</td>";
						}
					}//end date foreach
						
					echo "</tr>";
					
				}//end student foreach
				
				?>
					
				</tr>
				
			</tbody>
					
		</table>
	</div>
</div>