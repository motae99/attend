<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Course;
use app\models\Semester;
use app\models\Student;
use dosamigos\chartjs\ChartJs;
// use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

?>
<div class="site-index">
<div class="row">
    <div class="col-sm-7 ">

      <?php 
       
      // This is the required format
      $data =  array();
      $data[0][0] = "1course";
      $data[0][1] = "123";
      $data[1][0] = "2course";
      $data[1][1] = "234";
      $data[2][0] = "3course";
      $data[2][1] = "345";

      echo ChartJs::widget([
            'type' => 'Line',
            'options' => [
                'height' => 300,
                'width' => 650
            ], 
            'data' => [
                'labels' => ["January", "February", "March", "April", "May", "June", "July", "Augest", "Septemper"],
                'datasets' => [
                    [
                        'fillColor' => "rgba(220,220,220,0.5)",
                        'strokeColor' => "rgba(220,220,220,1)",
                        'pointColor' => "rgba(220,220,220,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [65, 59, 90, 81, 56, 55, 40, 50, 60]
                    ],
                    [
                        'fillColor' => "rgba(151,187,205,0.5)",
                        'strokeColor' => "rgba(151,187,205,1)",
                        'pointColor' => "rgba(151,187,205,1)",
                        'pointStrokeColor' => "#fff",
                        'data' => [28, 48, 40, 19, 96, 27, 100, 48, 58]
                    ]
                ]
            ]
        ]);
        
        

        
      ?>
    </div>

    <div class="col-sm-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                      <h3><?= Course::find()->count();?></h3>
                      <p>
                        <?= Html::button('', ['value' => Url::to(['course/add']), 'title' => 'Add Course', 'class' => 'showModalButton bg-maroon btn fa fa-2x fa-graduation-cap'])?>
                      </p>

                    </div>
                    <div class="icon">
                      <i class="fa fa-sitemap"></i>
                    </div>
                    <a class="small-box-footer" href="index.php?r=semester">
                      Manage Semesters <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                      <h3><?= Student::find()->count();?></h3>
                        <p>
                         <?= Html::button('', ['value' => Url::to(['student/add']), 'title' => 'Register A Student', 'class' => 'showModalButton bg-purple btn fa fa-2x fa-user'])?>
                        </p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                    <a class="small-box-footer" href="index.php?r=student">
                      Manage Students <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>

            </div>


            <div class="col-sm-6">
                <div class="info-box bg-orange">
                  <a class="info-box-icon" href="index.php?r=attendance/sync">
                     <i class="fa fa-refresh" style="color: #fff;"></i>
                  </a>
                  <div class="info-box-content">
                    <span class="info-box-text">Sync Device </span>
                    <span class="info-box-number">41,410</span>
                    <div class="progress">
                      <div style="width: 70%" class="progress-bar"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="info-box bg-navy">
                  <span class="info-box-icon"><i class="fa fa-refresh"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Bookmarks</span>
                    <span class="info-box-number">41,410</span>
                    <div class="progress">
                      <div style="width: 70%" class="progress-bar"></div>
                    </div>
                    <span class="progress-description">
                      70% Increase in 30 Days
                    </span>
                  </div><!-- /.info-box-content -->
                </div>
            </div>
        </div>
    </div>
</div>


<?php //$this->renderPartial('part');?>



<div class="body-content">
  <div class="row">
    <div class="col-sm-7">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Manage Current Active Course</h3>
          <div class="box-tools pull-right">
            <button data-widget="collapse" class="btn btn-info btn-sm"><i class="fa fa-minus"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body" style="padding-bottom: 30px;">
          <div class="box-group" id="accordion">
            <div class="panel box box-default">
        <?php $charts = array();
          $courses = Course::find()->all(); 
          foreach ($courses as $course) {
          $s = 0;
            $semesters = $course->semesters;
            $batches = Semester::find()->where(['course_id' => $course->id])->count();

              foreach ($semesters as $sem => $semester) {
                $students = Student::find()->where(['sem_id' => $semester['id']])->count();
                $s += $students;
              }
                $charts[$course->id]['label'] = $course->course_name;
                $charts[$course->id]['value'] = $s;

        ?>
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a style="color:#3c8dbc" aria-expanded="true" data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?= $course->course_name ?></a>        
                </h4>
                <div class="pull-right box-tools">
                    <span class="btn btn-sm btn-info disp-count">
                      <i class="fa fa-users">
                        
                      </i> Students &nbsp;
                      <span class="badge">
                          <?= $s?>           
                      </span>
                    </span>
                     <span class="btn btn-sm btn-warning disp-count">
                      <i class="fa fa-sitemap"></i> Semesters &nbsp;
                      <span class="badge">
                          <?= $batches?>           
                      </span>
                    </span>
                  <!-- Add Search prams to href -->
                  <a title="View Course Semester" href="index.php?r=semester" class="btn-sm btn btn-default"><i class="fa fa-eye"></i></a>
                  <a title="Edit Course Details" href="index.php?r=course%2Fupdate&amp;id=<?= $course->id?>" class="btn-sm btn btn-default"><i class="fa fa-pencil-square-o"></i></a>
                  <!-- <a data-method="post" data-confirm="Are you sure you want to delete this item?" title="Delete" href="/4/index.php?r=course%2Fcourses%2Fdelete&amp;id=4" class="btn-sm btn btn-default"><i class="fa fa-trash-o"></i></a> -->                
                </div>
              </div>
          
        <?php
          }
        ?>
        
            </div><!-- /.panel box -->
          </div><!-- /.box-group -->
        </div><!-- /.box-body -->
      </div> <!-- end of box box-primary -->

    </div> <!-- end of col-sm-7 -->
    
    <div class="col-sm-5">
      <?php
      $colors = array();
      $colors[1]['color'] = "#F7464A";
      $colors[1]['highlight'] = '#FF5A5E';
      $colors[2]['color'] = "#4D5360";
      $colors[2]['highlight'] = '#616774';
      $colors[3]['color'] = "#FDB45C";
      $colors[3]['highlight'] = '#FFC870';
      $colors[4]['color'] = "#46BFBD";
      $colors[4]['highlight'] = '#5AD3D1';
      $colors[5]['color'] = "#949FB1";
      $colors[5]['highlight'] = '#A8B3C5';
      $colors[6]['color'] = "#FDB45C";
      $colors[6]['highlight'] = '#FFC870';

      // echo $colors[0]['color']."<br>";
      // echo $colors[0]['highlight']."<br>";
      // echo $colors[1]['color']."<br>";
      // echo $colors[1]['highlight']."<br>";

        $data = array();
        foreach ($charts as $k => $v) {
          $data[$k]['value'] = $v['value'];
          $data[$k]['label'] = $v['label'];
          $data[$k]['color'] = $colors[$k]['color'];
          $data[$k]['highlight'] = $colors[$k]['highlight'];
        }
      ?>
     <div class="box box-warning">
      <div class="box-header with-border">
        <h6 class="box-title"><i class="fa fa-pie-chart"></i> Current Course Wise Total Student</h6>
        <div class="box-tools pull-right">
          <button data-widget="collapse" class="btn btn-warning btn-sm"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-6">
          <div style=" margin-left: -50px;">
          <?=
            ChartJs::widget([
                  'type' => 'Pie',
                  'options' => [
                    'responsive'=> "true",
                  ], 
                  'data' => $data,
              ]);
          ?>
          </div>
        </div>
        <div class="col-sm-6">
          <div style=" margin-left: -50px;">

          <?=
            ChartJs::widget([
                  'type' => 'Doughnut',
                  'options' => [
                    'responsive'=> "true",
                  ], 
                  'data' => $data,
              ]);
          ?>
          </div>
        </div>
      </div>
     </div>

    
         
    </div>
            
  </div>
    <div class="box box-info">
      <?php 
            $events = array();
        //Testing
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 1;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:m:s\Z');
        $events[] = $Event;

        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 2;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:m:s\Z',strtotime('tomorrow 6am'));
        $events[] = $Event;

        ?>
        
        <?php echo \yii2fullcalendar\yii2fullcalendar::widget(array(
            'events'=> $events,
        ));?>
    </div>

</div>
</div>
<?php 
// $script = <<<JS

// var pieData = [
//         {
//           value: 12,
//           color:"#F7464A",
//           animationSteps : 100,
//           highlight: "#FF5A5E",
//           label: "la"
//         },
//         {
//           value: 50,
//           color: "#46BFBD",
//           highlight: "#5AD3D1",
//           animationSteps : 100,
//           label: "l2"
//         },

//       ];
  
// $(document).ready(function() {
//    var ctx = $("#Pie").getContext("2d");
//   window.myPie = new Chart(ctx).Pie(pieData);
// });
// JS;

// jQuery(document).ready(function(){;
//   var chartJS_w0=new Chart(document.getElementById('221').getContext('2d')).Line({"labels":["January","February","March","April","May","June","July","Augest","Septemper"],"datasets":[{"fillColor":"rgba(220,220,220,0.5)","strokeColor":"rgba(220,220,220,1)","pointColor":"rgba(220,220,220,1)","pointStrokeColor":"#fff","data":[65,59,90,81,56,55,40,50,60]},{"fillColor":"rgba(151,187,205,0.5)","strokeColor":"rgba(151,187,205,1)","pointColor":"rgba(151,187,205,1)","pointStrokeColor":"#fff","data":[28,48,40,19,96,27,100,48,58]}]},{});});
// $this->registerJs($script);
?>