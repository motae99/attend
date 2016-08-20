<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Calender */

$this->title = 'Update Calender: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="calender-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
