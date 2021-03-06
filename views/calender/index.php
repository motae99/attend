<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CalenderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calenders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calender-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Calender', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sub_id',
            'day',
            'start_time',
            'end_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
