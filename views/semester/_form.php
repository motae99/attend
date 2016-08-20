<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Course;
use kartik\date\DatePicker;



/* @var $this yii\web\View */
/* @var $model app\models\Semester */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semester-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(Course::find()->all(), 'id', 'course_name'),
        [ 'prompt'=>'---Select Course ---']);

    ?>

    <?= $form->field($model, 'sem_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_of_subjects')->textInput() ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Select Start date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]    
        ]) ;
    ?>   



    <?=  $form->field($model, 'end_date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Select End date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]    
        ]) ;
    ?>   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
