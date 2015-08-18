<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spare */

$this->title = 'Update Spare: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Spares', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spare-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
