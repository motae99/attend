<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Engineers */

$this->title = 'Create Engineers';
$this->params['breadcrumbs'][] = ['label' => 'Engineers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="engineers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
