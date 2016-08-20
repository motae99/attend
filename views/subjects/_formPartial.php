<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use app\models\Course;
use app\models\Semester;
use kartik\time\TimePicker;



/* @var $this yii\web\View */
/* @var $model app\models\Subjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course')->dropDownList(ArrayHelper::map(Course::find()->all(), 'id', 'course_name'),
                [       'prompt'=>'---Select course ---',
                        'onchange'=>'
                            $.get( "'.Url::toRoute('sem').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'sem_id').'" ).html( data );
                            }
                        );'    
                    ]);


    ?>

    <?= $form->field($model, 'sem_id')->dropDownList([''=>'---Select Sem ---']); ?>



    <?= $form->field($model, 'sub_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_of_lect')->textInput() ?>
	<div class='row'>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12" >  
                    <?= Html::Button('Sat' , ['class' =>'btn btn-block btn-flat bg-navy sat-button']) ?>

                </div>
                <div class="col-sm-12 sat-time">
                <?php echo $form->field($model, 'sat_start_time')->widget(TimePicker::classname(), 
                        [
                    
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'format' => 24
                    ],
                    'disabled' => true
                ])->label(false);?>
                </div>
                <div class="col-sm-12 sat-time">
                    <?= $form->field($model, 'sat_end_time')->widget(TimePicker::classname(), 
                        [
                    'pluginOptions' => [
                        'showSeconds' => false
                    ],
                    'disabled' => true
                ])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12">  
                    <?= Html::Button('Sun' , ['class' =>'btn btn-block btn-flat bg-purple sun-button']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'sun_start_time')->textInput(['disabled' => true])->label(false); ?>
                </div>

                <div class="col-sm-6">
                    <?= $form->field($model, 'sun_end_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12"> 
                    <?= Html::Button('Mon' , ['class' =>'btn btn-block btn-flat bg-olive mon-button']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'mon_start_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'mon_end_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12"> 
                    <?= Html::Button('Tue' , ['class' =>'btn btn-block btn-flat bg-orange tue-button']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'tue_start_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'tue_end_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12"> 
                    <?= Html::Button('Wen' , ['class' =>'btn btn-block btn-flat bg-black wen-button']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'wen_start_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'wen_end_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12"> 
                    <?= Html::Button('The' , ['class' =>'btn btn-block btn-flat bg-yellow the-button']) ?>
                </div>
                <div class="col-sm-6 disable">
                    <?= $form->field($model, 'the_start_time')->textInput(['disabled' => true])->label(false);?>
                
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'the_end_time')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>
		
	</div>
 
        
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-block trial' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$script = <<< JS
$('.sat-button').click(function(){
    $('#subjects-sat_start_time, #subjects-sat_end_time').prop('disabled', false);
})
$('.sun-button').click(function(){
    $('#subjects-sun_start_time, #subjects-sun_end_time').prop('disabled', false);
})
$('.mon-button').click(function(){
    $('#subjects-mon_start_time, #subjects-mon_end_time').prop('disabled', false);
})
$('.tue-button').click(function(){
    $('#subjects-tue_start_time, #subjects-tue_end_time').prop('disabled', false);
})
$('.wen-button').click(function(){
    $('#subjects-wen_start_time, #subjects-wen_end_time').prop('disabled', false);
})
$('.the-button').click(function(){
    $('#subjects-the_start_time, #subjects-the_end_time').prop('disabled', false);
})

JS;
$this->registerJs($script);
?>