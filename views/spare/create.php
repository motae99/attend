<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Spare */

$this->title = 'Create Spare';
$this->params['breadcrumbs'][] = ['label' => 'Spares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spare-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
