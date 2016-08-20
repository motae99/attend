<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Calender */

$this->title = 'Create Calender';
$this->params['breadcrumbs'][] = ['label' => 'Calenders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calender-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
