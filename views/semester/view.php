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

         
  <?= Html::button('', ['value' => Url::to(['subjects/add', 'sem_id' => $model->id]), 'title' => 'Add a Subject', 'class' => 'showModalButton btn btn-default fa fa-plus'])?>
  <?php Pjax::begin(['id'=>'timeTable']); ?>

       <?= \yii2fullcalendar\yii2fullcalendar::widget([
        'options' => ['language' => 'en-us'],
        
        'clientOptions' => [
            'minTime'=> "00:00:00",
            'maxTime'=> "23:59:59",
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
  <?php Pjax::end();  ?>
