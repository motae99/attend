<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Calender;

/* @var $this yii\web\View */
/* @var $model app\models\Subjects */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sem_id',
            'sub_name',
            'no_of_lect',
            'color_class',
        ],
    ]) ?>

</div>
<?php $events = array();
    $cal = Calender::find()->where(['sub_id' => $model->id])->all();
    foreach ($cal as $k => $v) {
        # code...
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $v['id'];
        $Event->title = $v->sub->sub_name;
    // var_dump($subject);
        // $Event->title = $subject->sub_name;
        $Event->start = $v->date." ".$v->start_time;
        $Event->end = $v->date." ".$v->end_time;
        $events[] = $Event;
        // var_dump($events);
    }
       

  ?>
  
  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> $events,
  ));
    ?>

