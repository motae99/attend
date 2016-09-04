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

$studentsCount = Student::find()->where(['sem_id'=> 3])->count();
$total = Calender::find()->where(['sub_id'=> $subject_id])->count();
$done = Calender::find()->where(['sub_id'=> $subject_id, 'status' => 'done'])->count();
$remaining = Calender::find()->where(['sub_id'=> $subject_id, 'status' => 'schedualed'])->count();
$canceled = Calender::find()->where(['sub_id'=> $subject_id, 'status' => 'canceled'])->count();

// foreach ($dates as $date ) {
	
// }
// $no = Calender::find()->where(['sub_id'=> $subject_id])->count();
// // echo $no;
?>
<div class="row">
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$studentsCount?></h3>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a class="small-box-footer" href="#">
          <!-- More info --> <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?=$total?></h3>
          
        </div>
        <div class="icon">
          <i class="fa fa-calendar"></i>
        </div>
        <a class="small-box-footer" href="#">
          <!-- More info --> <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?=$done?></h3>
        </div>
        <div class="icon">
          <i class="fa fa-calendar-check-o"></i>
        </div>
        <a class="small-box-footer" href="#">
          <!-- More info --> <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?=$canceled?></h3>

        </div>
        <div class="icon">
          <i class="fa fa-calendar-minus-o"></i>
        </div>
        <a class="small-box-footer" href="#">
          <!-- More info --> <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-2 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?=$remaining?></h3>
        </div>
        <div class="icon">
          <i class="fa fa-calendar-plus-o"></i>
        </div>
        <a class="small-box-footer" href="#">
          <!-- More info --> <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
	</div><!-- ./col -->
    
    <div class="col-lg-2 col-xs-6">
		<div class="col-md-3 col-sm-6 col-xs-6 text-center">
          <div style="display:inline;width:120px;height:120px;"><canvas width="130" height="130" style="width: 120px; height: 120px;"></canvas><input type="text" data-fgcolor="#00c0ef" data-height="120" data-width="120" data-angleoffset="-125" data-anglearc="250" data-thickness="0.2" data-skin="tron" value="100" class="knob" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px none; background: transparent none repeat scroll 0% 0%; font: bold 24px Arial; text-align: center; color: rgb(0, 192, 239); padding: 0px;"></div>
          <div class="knob-label">data-angleArc="250"</div>
        </div>
	</div><!-- ./col -->



 </div>
<div class="box">
	<div class="table-responsive">
		<table class="table invoice-items">
			<thead>
				<tr class="h5 text-dark">
					    	<th class="text-center" >
								Student Name
							</th>
							<!-- <th class="text-center" >
								Lect
							</th> -->
							<th class="text-center" >
								P
							</th>
							<th class="text-center" >
								A
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
						echo $student->name;
						echo "</td>";
						$present = Attendance::find()->where(['stu_id' => $s_id])->count();
						echo "<td class='text-center'>";
						echo $present;
						echo "</td>";
						echo "<td class='text-center'>";
						echo $done-$present;
						echo "</td>";
						// $classes = Attendance::find()->where(['stu_id' => $s_id, 'time_table_id' => $date->id])->all();
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