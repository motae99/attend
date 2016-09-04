<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Course;
use app\models\Semester;
use app\models\Student;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

?>
<div class="site-index">
<div class="row">
    <div class="col-sm-7 ">

        <div class="col-sm-10">
        <?= ChartJs::widget([
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
    </div>
    <div class="col-sm-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="small-box bg-maroon">
                    <div class="inner">
                      <h3>150</h3>
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
                      <h3>150</h3>
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
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Manage Current Active Course</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="box-group" id="accordion">
            <div class="panel box box-default">
        <?php
          $courses = Course::find()->all(); 
          foreach ($courses as $course) {
          $s = 0;
            $semesters = $course->semesters;
            $batches = Semester::find()->where(['course_id' => $course->id])->count();

              foreach ($semesters as $sem => $semester) {
                $students = Student::find()->where(['sem_id' => $semester['id']])->count();
                $s += $students;
              }
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
      
      <div class="box">
                    
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
          
          <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
              'events'=> $events,
          ));?>
      </div>

      
    </div> <!-- end of col-sm-7 -->
    
    <div class="col-sm-5">
         <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Current Course Wise Total Student</h3>
                    <div class="box-tools pull-right">
                        <button data-widget="collapse" class="btn btn-success btn-sm"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
            <div id="w0" data-highcharts-chart="0"><div class="highcharts-container" id="highcharts-0" style="position: relative; overflow: hidden; width: 439px; height: 400px; text-align: left; line-height: normal; z-index: 0; left: 0px; top: 0.5px;"><svg version="1.1" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;" xmlns="http://www.w3.org/2000/svg" width="439" height="400"><desc>Created with Highcharts 4.0.4</desc><defs><clipPath id="highcharts-1"><rect x="0" y="0" width="439" height="400"/></clipPath></defs><rect x="0" y="0" width="439" height="400" strokeWidth="0" fill="#FFFFFF" class=" highcharts-background"/><path fill="rgba(124,181,236,0.25)" d="M 0 0"/><g class="highcharts-series-group" zIndex="3"><g class="highcharts-series highcharts-tracker" visibility="visible" zIndex="0.1" transform="translate(10,10) scale(1 1)" style=""><path fill="rgba(99,156,211,1)" d="M 209.47189309789007 79.0000014311557 L 209.47189309789007 108.2283588088805 L 209.48981633981523 152.22835789625947 L 209.48981633981523 123.00000051853468 Z" zIndex="-136.6199971663117" transform="translate(0,0)" visibility="visible"/><path fill="rgba(222,138,67,1)" d="M 209.4449407083736 79.0000054918944 L 209.4449407083736 108.2283628696192 L 209.48005098129477 152.2283593675416 L 209.48005098129477 123.00000198981681 Z" zIndex="-136.61998912604906" transform="translate(0,0)" visibility="visible"/><path fill="rgba(222,138,67,1)" d="M 116.51055375254381 97.01725074451295 C 143.00378819637064 84.93673705992411 173.58902752555792 79.00715839529148 209.4449407083736 79.0000054918944 L 209.4449407083736 108.2283628696192 C 173.58902752555792 108.23551577301629 143.00378819637064 114.16509443764892 116.51055375254381 126.24560812223775 Z" zIndex="-101.96549851097409" transform="translate(0,0)" visibility="visible"/><path fill="rgba(222,138,67,1)" d="M 175.8081716494724 129.52798940018585 C 185.40716963636618 125.1509916883783 196.48877808897024 123.00259362148242 209.48005098129477 123.00000198981681 L 209.48005098129477 152.2283593675416 C 196.48877808897024 152.2309509992072 185.40716963636618 154.3793490661031 175.8081716494724 158.75634677791064 Z" zIndex="-101.96549851097409" transform="translate(0,0)" visibility="visible"/><path fill="rgba(119,212,100,1)" d="M 116.50953410220819 97.01771569429332 L 116.50953410220819 126.24607307201812 L 175.807802210945 158.756515237976 L 175.807802210945 129.5281578602512 Z" zIndex="-100.94492292529921" transform="translate(0,0)" visibility="visible"/><path fill="rgba(222,138,67,1)" d="M 116.51055375254381 97.01725074451295 L 116.51055375254381 126.24560812223775 L 175.8081716494724 158.75634677791064 L 175.8081716494724 129.52798940018585 Z" zIndex="-100.94584352586435" transform="translate(0,0)" visibility="visible"/><path fill="rgba(42,42,47,1)" d="M 76.78330292756681 166.90951029365914 L 76.78330292756681 196.13786767138393 L 161.4142401911474 184.07962922325348 L 161.4142401911474 154.8512718455287 Z" zIndex="37.440830381445075" transform="translate(0,0)" visibility="visible"/><path fill="rgba(119,212,100,1)" d="M 76.78292474399677 166.9088467092283 C 73.09190660510394 160.43223367666772 71.5 154.7344205466352 71.5 148 L 71.5 177.2283573777248 C 71.5 183.96277792435998 73.09190660510394 189.6605910543925 76.78292474399677 196.1372040869531 Z" zIndex="37.81769341845659" transform="translate(0,0)" visibility="visible"/><path fill="rgba(119,212,100,1)" d="M 161.41410316811476 154.85103141638706 C 156.07145274063694 145.47630658845713 161.402876980537 136.09671754054273 175.807802210945 129.5281578602512 L 175.807802210945 158.756515237976 C 161.402876980537 165.32507491826752 156.07145274063694 174.70466396618193 161.41410316811476 184.07938879411185 Z" zIndex="37.81769341845659" transform="translate(0,0)" visibility="visible"/><path fill="rgba(119,212,100,1)" d="M 76.78292474399677 166.9088467092283 L 76.78292474399677 196.1372040869531 L 161.41410316811476 184.07938879411185 L 161.41410316811476 154.85103141638706 Z" zIndex="37.439516484272026" transform="translate(0,0)" visibility="visible"/><path fill="rgba(99,156,211,1)" d="M 282.1954588583578 206.6501710597949 L 282.1954588583578 235.8785284375197 L 235.83893436897023 198.47841935591134 L 235.83893436897023 169.25006197818655 Z" zIndex="116.12733869839386" transform="translate(0,0)" visibility="visible"/><path fill="rgba(42,42,47,1)" d="M 282.1942858513019 206.65053453415666 L 282.1942858513019 235.87889191188145 L 235.83850936641375 198.4785510495207 L 235.83850936641375 169.2501936717959 Z" zIndex="116.12805837763018" transform="translate(0,0)" visibility="visible"/><path fill="rgba(99,156,211,1)" d="M 347.5 148 C 347.5 172.6480007402742 324.097182327895 193.66612958330666 282.1954588583578 206.6501710597949 L 282.1954588583578 235.8785284375197 C 324.097182327895 222.89448696103145 347.5 201.876358117999 347.5 177.2283573777248 Z" zIndex="117.30034211958976" transform="translate(0,0)" visibility="visible"/><path fill="rgba(99,156,211,1)" d="M 209.48981633981523 123.00000051853468 C 237.10405325859733 122.99718837842593 259.49437468271316 134.1877897105166 259.49999896293065 147.99490816990763 C 259.5036374728226 156.92713329947316 251.02376169243522 164.54475605146212 235.83893436897023 169.25006197818655 L 235.83893436897023 198.47841935591134 C 259.31110469599344 191.20512346652313 266.5467157351495 175.7949753567513 252.0001239563731 164.05889019323968 C 242.58951210292426 156.4664765315072 227.35426659894625 152.22653864131348 209.48981633981523 152.22835789625947 Z" zIndex="117.30034211958976" transform="translate(0,0)" visibility="visible"/><path fill="rgba(42,42,47,1)" d="M 282.1942858513019 206.65053453415666 C 217.41069426602385 226.7245072719139 132.34687640720117 216.73893871829 92.19893093168669 184.34714292565096 C 85.11414451593059 178.63106076763378 80.4691453590106 173.37679614392624 76.78330292756681 166.90951029365914 L 76.78330292756681 196.13786767138393 C 97.6701712514795 232.78657159189294 174.02161274630026 254.03014007589778 247.31902058731825 243.58670591394142 C 260.2535922878524 241.7437846982195 270.76212153526757 239.42128511975952 282.1942858513019 235.87889191188145 Z" zIndex="128.7011209357422" transform="translate(0,0)" visibility="visible"/><path fill="rgba(42,42,47,1)" d="M 235.83850936641375 169.2501936717959 C 212.36619357464633 176.5233721999688 181.54596971275404 172.90541257909058 166.99961265640823 161.16925468320687 C 164.4326610564966 159.09821042305572 162.7496903474676 157.19449135649504 161.4142401911474 154.8512718455287 L 161.4142401911474 184.07962922325348 C 168.98194610560853 197.35814513648137 196.64551186460156 205.05509023938166 223.20254369105734 201.2712372821511 C 227.88898271299 200.603512203991 231.69642084611144 199.7620268494765 235.83850936641375 198.4785510495207 Z" zIndex="128.7011209357422" transform="translate(0,0)" visibility="visible"/><g zIndex="13800" stroke="#7cb5ec" stroke-width="1" stroke-linejoin="round" _args="NaN"><path fill="#7cb5ec" d="M 209.47189309789007 79.0000014311557 C 285.68718699372863 78.99223992445555 347.4844741242883 109.87829960102574 347.4999971376886 147.98594654894504 C 347.5100394249905 172.63888790654585 324.1055822711212 193.66352670203548 282.1954588583578 206.6501710597949 L 235.83893436897023 169.25006197818655 C 259.31110469599344 161.97676608879834 266.5467157351495 146.56661797902652 252.0001239563731 134.83053281551489 C 242.58951210292426 127.23811915378239 227.35426659894625 122.99818126358868 209.48981633981523 123.00000051853468 Z" zIndex="138" transform="translate(0,0)" visibility="visible"/></g><g zIndex="13800" stroke="#434348" stroke-width="1" stroke-linejoin="round" _args="NaN"><path fill="#434348" d="M 282.1942858513019 206.65053453415666 C 217.41069426602385 226.7245072719139 132.34687640720117 216.73893871829 92.19893093168669 184.34714292565096 C 85.11414451593059 178.63106076763378 80.4691453590106 173.37679614392624 76.78330292756681 166.90951029365914 L 161.4142401911474 154.8512718455287 C 168.98194610560853 168.12978775875658 196.64551186460156 175.82673286165686 223.20254369105734 172.04287990442631 C 227.88898271299 171.3751548262662 231.69642084611144 170.53366947175172 235.83850936641375 169.2501936717959 Z" zIndex="138" transform="translate(0,0)" visibility="visible"/></g><g zIndex="13800" stroke="#90ed7d" stroke-width="1" stroke-linejoin="round" _args="NaN"><path fill="#90ed7d" d="M 76.78292474399677 166.9088467092283 C 62.037209564157955 141.03460618414172 76.7519404662821 115.14694041189793 116.50953410220819 97.01771569429332 L 175.807802210945 129.5281578602512 C 161.402876980537 136.09671754054273 156.07145274063694 145.47630658845713 161.41410316811476 154.85103141638706 Z" zIndex="138" transform="translate(0,0)" visibility="visible"/></g><g zIndex="13800" stroke="#f7a35c" stroke-width="1" stroke-linejoin="round" _args="NaN"><path fill="#f7a35c" d="M 116.51055375254381 97.01725074451295 C 143.00378819637064 84.93673705992411 173.58902752555792 79.00715839529148 209.4449407083736 79.0000054918944 L 209.48005098129477 123.00000198981681 C 196.48877808897024 123.00259362148242 185.40716963636618 125.1509916883783 175.8081716494724 129.52798940018585 Z" zIndex="138" transform="translate(0,0)" visibility="visible"/></g></g><g class="highcharts-markers" visibility="visible" zIndex="0.1" transform="translate(10,10) scale(1 1)"/></g><g class="highcharts-legend" zIndex="7" transform="translate(175,326)"><g zIndex="1"><g><g class="highcharts-legend-item" zIndex="1" transform="translate(8,3)"><text x="21" style="color:#333333;font-size:12px;font-weight:bold;cursor:pointer;fill:#333333;" text-anchor="start" zIndex="2" y="15"><tspan>MCA (7)</tspan></text><rect x="0" y="4" width="16" height="12" zIndex="3" fill="#7cb5ec"/></g><g class="highcharts-legend-item" zIndex="1" transform="translate(8,17)"><text x="21" y="15" style="color:#333333;font-size:12px;font-weight:bold;cursor:pointer;fill:#333333;" text-anchor="start" zIndex="2"><tspan>BCA (5)</tspan></text><rect x="0" y="4" width="16" height="12" zIndex="3" fill="#434348"/></g><g class="highcharts-legend-item" zIndex="1" transform="translate(8,31)"><text x="21" y="15" style="color:#333333;font-size:12px;font-weight:bold;cursor:pointer;fill:#333333;" text-anchor="start" zIndex="2"><tspan>M.Sc.IT (3)</tspan></text><rect x="0" y="4" width="16" height="12" zIndex="3" fill="#90ed7d"/></g><g class="highcharts-legend-item" zIndex="1" transform="translate(8,45)"><text x="21" y="15" style="color:#333333;font-size:12px;font-weight:bold;cursor:pointer;fill:#333333;" text-anchor="start" zIndex="2"><tspan>B.Sc.IT (2)</tspan></text><rect x="0" y="4" width="16" height="12" zIndex="3" fill="#f7a35c"/></g></g></g></g><g class="highcharts-tooltip" zIndex="8" style="cursor:default;padding:0;white-space:nowrap;" transform="translate(259,-9999)" opacity="0" visibility="visible"><path fill="none" d="M 3.5 0.5 L 108.5 0.5 C 111.5 0.5 111.5 0.5 111.5 3.5 L 111.5 41.5 C 111.5 44.5 111.5 44.5 108.5 44.5 L 3.5 44.5 C 0.5 44.5 0.5 44.5 0.5 41.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" isShadow="true" stroke="black" stroke-opacity="0.049999999999999996" stroke-width="5" transform="translate(1, 1)" width="111" height="44"/><path fill="none" d="M 3.5 0.5 L 108.5 0.5 C 111.5 0.5 111.5 0.5 111.5 3.5 L 111.5 41.5 C 111.5 44.5 111.5 44.5 108.5 44.5 L 3.5 44.5 C 0.5 44.5 0.5 44.5 0.5 41.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" isShadow="true" stroke="black" stroke-opacity="0.09999999999999999" stroke-width="3" transform="translate(1, 1)" width="111" height="44"/><path fill="none" d="M 3.5 0.5 L 108.5 0.5 C 111.5 0.5 111.5 0.5 111.5 3.5 L 111.5 41.5 C 111.5 44.5 111.5 44.5 108.5 44.5 L 3.5 44.5 C 0.5 44.5 0.5 44.5 0.5 41.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" isShadow="true" stroke="black" stroke-opacity="0.15" stroke-width="1" transform="translate(1, 1)" width="111" height="44"/><path fill="rgba(249, 249, 249, .85)" d="M 3.5 0.5 L 108.5 0.5 C 111.5 0.5 111.5 0.5 111.5 3.5 L 111.5 41.5 C 111.5 44.5 111.5 44.5 108.5 44.5 L 3.5 44.5 C 0.5 44.5 0.5 44.5 0.5 41.5 L 0.5 3.5 C 0.5 0.5 0.5 0.5 3.5 0.5" stroke="#7cb5ec" stroke-width="1"/><text x="8" zIndex="1" style="font-size:12px;color:#333333;fill:#333333;" y="21"><tspan style="font-size: 10px">MCA (7)</tspan><tspan style="fill:" x="8" dy="16">●</tspan><tspan dx="0"> Total Student: </tspan><tspan style="font-weight:bold" dx="0">7</tspan></text></g></svg></div></div>  </div>
        </div>
         
    </div>
            
  </div>

</div>
</div>
