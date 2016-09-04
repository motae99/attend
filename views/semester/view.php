<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $model app\models\Semester */

$this->title = $model->sem_name;
$this->params['breadcrumbs'][] = ['label' => 'Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

         
  
<div class="row">
<?php Pjax::begin(['id'=>'timeTable']); ?>
    <div class="col-sm-10">
       <?= \yii2fullcalendar\yii2fullcalendar::widget([
        'options' => ['language' => 'en-us'],
        
        'clientOptions' => [
            'minTime'=> "08:00:00",
            'maxTime'=> "18:59:59",
            'default' => 'agendaWeek',
            'fixedWeekCount' => false,
            'weekNumbers'=>true,
            'editable' => true,
            'selectable' => true,
            // 'eventLimit' => true,
            // 'eventLimitText' => 'More Outstanding',
            'selectHelper' => true,
            'header' => [
                'right' => 'month,agendaWeek,agendaDay',
                'center' => 'title',
                'left' => 'today prev,next'
            ],
            // 'select' =>  new \yii\web\JsExpression($JSEvent),
            // 'eventClick' => new \yii\web\JsExpression($JSEventClick),
            // 'eventRender' => new \yii\web\JsExpression($JsF),
            'aspectRatio' => 2,
            'timeFormat' => 'hh(:mm) A'
        ],
        'ajaxEvents' => Url::toRoute(['table', 'id' =>$model->id])
      ]); ?> 
    </div>
<?php Pjax::end();  ?>
    <div class="col-sm-2">
        <?php echo Html::button(' Add subject', ['value' => Url::to(['subjects/add', 'sem_id' => $model->id]), 'title' => 'Add a Subject', 'class' => 'showModalButton btn btn-success btn-block fa fa-plus'])?>
        <?php //echo Html::button('', ['value' => Url::to(['subjects/create']), 'title' => 'Add a Subject', 'class' => 'btn btn-info fa fa-plus'])?>
        <?php
            foreach ($subjects as $subject ) {
                $class = "btn btn-block ".$subject->color_class;
                $name = $subject->sub_name;
                $no = $subject->no_of_lect;
                
            ?>
            <button class="<?= $class?>" style=" color: #fff; text-align: left;">
                <span class="pull-right badge bg-green"><?= $no;?></span>
                <?= $name;?>
            </button>
            <?php    
            } 
            
            
        ?>
    

        
    </div>
</div>

       
