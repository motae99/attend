<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;
use kartik\widgets\ActiveForm;
use app\models\Course;
use kartik\color\ColorInput;
use app\models\Semester;
use kartik\time\TimePicker;



/* @var $this yii\web\View */
/* @var $model app\models\Subjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'course')->dropDownList(ArrayHelper::map(Course::find()->all(), 'id', 'course_name'),
                [       'prompt'=>'---Select course ---',
                        'onchange'=>'
                            $.get( "'.Url::toRoute('sem').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($model, 'sem_id').'" ).html( data );
                            }
                        );'    
                ])->label(false) ;
            ?>

            <?= $form->field($model, 'sem_id')->dropDownList([''=>'---Select Sem ---'])->label(false) ; ?>

            <?php // $form->field($model, 'sem_id')->textInput() ?>
            <?= $form->field($model, 'sub_name')->textInput(['maxlength' => true])->label(false) ?>
            <?= $form->field($model, 'no_of_lect')->textInput()->label(false) ?>
            <div class="btn-group col-sm-12">
                <div class="col-sm-4">
                    <button class="btn btn-flat btn-block margin bg-maroon" type="button" style="margin-left: -1px;"> # </button>
                    <button class="btn btn-flat btn-block margin bg-navy" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-green" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-orange" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-olive" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-aqua" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-teal-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-fuchsia-active" type="button"> # </button>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-flat btn-block margin bg-purple" type="button" style="margin-left: -1px;"> # </button>
                    <button class="btn btn-flat btn-block margin bg-lime" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-black" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-teal" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-fuchsia" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-red" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-lime-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-black-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-yellow-active" type="button"> # </button>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-flat btn-block margin bg-blue" type="button" style="margin-left: -1px;"> # </button>
                    <button class="btn btn-flat btn-block margin bg-maroon-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-navy-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-green-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-orange-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-olive-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-aqua-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-purple-active" type="button"> # </button>
                    <button class="btn btn-flat btn-block margin bg-red-active" type="button"> # </button>
                </div>
                
                <!-- <div class="col-sm-2">
                </div> -->
                

            </div>
            <div class="col-sm-12">
                <?= $form->field($model, 'color_class')->widget(ColorInput::classname(), [])->label(false) ?>     
            </div>
        </div>

        <div class="col-sm-6">
            <div class='row'>
                
                    <div class="col-sm-12" >  
                        <?= Html::Button('Sat' , ['class' =>'btn btn-block btn-flat bg-navy sat-button']) ?>

                    </div>
                    <div class="col-sm-6 sat-time">
                    <?php echo $form->field($model, 'sat_start_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-sm-6 sat-time">
                        <?= $form->field($model, 'sat_end_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                
                    <div class="col-sm-12">  
                        <?= Html::Button('Sun' , ['class' =>'btn btn-block btn-flat bg-purple sun-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'sun_start_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>

                    <div class="col-sm-6">
                        <?= $form->field($model, 'sun_end_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                
                    <div class="col-sm-12"> 
                            <?= Html::Button('Mon' , ['class' =>'btn btn-block btn-flat bg-olive mon-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'mon_start_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'mon_end_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                
                    <div class="col-sm-12"> 
                        <?= Html::Button('Tue' , ['class' =>'btn btn-block btn-flat bg-orange tue-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'tue_start_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'tue_end_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                
                    <div class="col-sm-12"> 
                        <?= Html::Button('Wen' , ['class' =>'btn btn-block btn-flat bg-black wen-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'wen_start_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'wen_end_time')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                
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
$script = <<<JS

$(document).ready(function() {
    
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

    $(".bg-maroon").click(function() {
    $('#subjects-color_class').val('bg-maroon');
    });
    $(".bg-maroon-active").click(function() {
    $('#subjects-color_class').val('bg-maroon-active');
    });
    
    $(".bg-purple").click(function() {
    $('#subjects-color_class').val('bg-purple');
     });
    $(".bg-purple-active").click(function() {
    $('#subjects-color_class').val('bg-purple-active');
     });
    
    $(".bg-navy").click(function() {
    $('#subjects-color_class').val('bg-navy');
     });
    $(".bg-navy-active").click(function() {
    $('#subjects-color_class').val('bg-navy-active');
     });
    $(".bg-olive").click(function() {
    $('#subjects-color_class').val('bg-olive');
    });
    $(".bg-olive-active").click(function() {
    $('#subjects-color_class').val('bg-olive-active');
    });
    $(".bg-orange").click(function() {
    $('#subjects-color_class').val('bg-orange');
    });
    $(".bg-orange-active").click(function() {
    $('#subjects-color_class').val('bg-orange-active');
    });
    $(".bg-yellow").click(function() {
    $('#subjects-color_class').val('bg-yellow');
    });
    $(".bg-yellow-active").click(function() {
    $('#subjects-color_class').val('bg-yellow-active');
    });
    $(".bg-green").click(function() {
    $('#subjects-color_class').val('bg-green');
    });
    $(".bg-green-active").click(function() {
    $('#subjects-color_class').val('bg-green-active');
    });
    $(".bg-blue").click(function() {
    $('#subjects-color_class').val('bg-blue');
    });
    $(".bg-aqua").click(function() {
    $('#subjects-color_class').val('bg-aqua');
    });
    $(".bg-aqua-active").click(function() {
    $('#subjects-color_class').val('bg-aqua-active');
    });
    $(".bg-black").click(function() {
    $('#subjects-color_class').val('bg-black');
    });
    $(".bg-black-active").click(function() {
    $('#subjects-color_class').val('bg-black-active');
    });
    $(".bg-teal").click(function() {
    $('#subjects-color_class').val('bg-teal');
    });
    $(".bg-teal-active").click(function() {
    $('#subjects-color_class').val('bg-teal-active');
    });
    $(".bg-lime").click(function() {
    $('#subjects-color_class').val('bg-lime');
    });
    $(".bg-lime-active").click(function() {
    $('#subjects-color_class').val('bg-lime-active');
    });
    $(".bg-fuchsia").click(function() {
    $('#subjects-color_class').val('bg-fuchsia');
    });
    $(".bg-fuchsia-active").click(function() {
    $('#subjects-color_class').val('bg-fuchsia-active');
    });
    $(".bg-yellow").click(function() {
    $('#subjects-color_class').val('bg-yellow');
    });
    $(".bg-yellow-active").click(function() {
    $('#subjects-color_class').val('bg-yellow-active');
    });
    $(".bg-red").click(function() {
    $('#subjects-color_class').val('bg-red');
    });
    $(".bg-red-active").click(function() {
    $('#subjects-color_class').val('bg-red-active');
    });

});

JS;
$this->registerJs($script);
?>

