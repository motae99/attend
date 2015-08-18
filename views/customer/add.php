<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Engineers', ['engineers/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'full_name',
            'phone_no',
            'car_type',
            'plate_no',
            
        ],
    ]) 
    ?>
    

 


</div>
    
   <div class=" profile-data">
        <ul class="nav nav-tabs responsive" id = "profileTab">
            <li class="active" id = "personal-tab"><a href="#personal" data-toggle="tab"><i class="fa fa-street-view"></i> Engineers</a></li>
            <li id = "academic-tab"><a href="#academic" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Spares</a></li>
        </ul>
         <div id='content' class="tab-content responsive">
            <div class="tab-pane active" id="personal">
                <div class="row">
                <div class="engineers-form col-lg-4 ">

                <?php $form = ActiveForm::begin(); ?>


                <?= $form->field($eng, 'phone_no')->textInput() ?>

                <?= $form->field($eng, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($eng, 'service_cost')->textInput() ?>

                <?= $form->field($eng, 'task')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Add engineers' , ['class' => 'btn btn-success' ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

                </div> 
                <div class="customer-view col-lg-8">
                <div class="box-body table-responsive">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Phone NO</th>
                            <th>Name</th>
                            <th>Service Cost</th>
                            <th>Task</th>
                            <th>Created AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($engin) : ?>
                        <?php foreach($engin as $k=>$v) : ?>
                        <tr>
                            <td><?= ($k+1); ?></td>
                            <td><?= $v['phone_no'];?></td>
                            <td><?= $v['name'];?></td>
                            <td><?= $v['service_cost'];?></td>
                            <td><?= $v['task'];?></td>
                            <td><?= $v['created_at'];?></td>
                        </tr>
                        
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-danger text-center">No Task has been defined</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            </div>
            </div>
            </div>
            <div class="tab-pane" id="academic">
                <div class="row">
                <div class="engineers-form col-lg-4 ">

                <?php $form = ActiveForm::begin(); ?>


                <?= $form->field($sp, 'spare_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($sp, 'part_number')->textInput(['maxlength' => true]) ?>

                <?= $form->field($sp, 'price')->textInput() ?>


                <div class="form-group">
                    <?= Html::submitButton('Add Spare' , ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                </div> 
                <div class="customer-view col-lg-8">
                <div class="box-body table-responsive">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>part_number</th>
                            <th>spare_name</th>
                            <th>price</th>
                            <th>Created AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($spa) : ?>
                        <?php foreach($spa as $k=>$s) : ?>
                        <tr>
                            <td><?= ($k+1); ?></td>
                            <td><?= $s['part_number'];?></td>
                            <td><?= $s['spare_name'];?></td>
                            <td><?= $s['price'];?></td>
                            <td><?= $s['created_at'];?></td>
                        </tr>
                        
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-danger text-center">No Spare Added</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            </div>
            </div>
            </div>
            
    
</div>


</div>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Maintenance_cost')->textInput() ?>

    <?= $form->field($model, 'service_cost')->textInput() ?>

    <?= $form->field($model, 'spare_cost')->textInput() ?>

    <?= $form->field($model, 'total_cost')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-lg btn-success' : 'btn btn-lg btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



                