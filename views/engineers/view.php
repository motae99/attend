<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Engineers */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Engineers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="engineers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<div class="row">
    <div class="col-lg-4">
    <?= DetailView::widget([
        'model' => $model, 
        'attributes' => [
            'customer.full_name',
            'customer.car_type',
            'customer.plate_no',
           
        ],
    ]) ?>
    </div>

    <div class="col-lg-8">
    <?= DetailView::widget([
        'model' => $model, 
        'attributes' => [
            'phone_no',
            'name',
            'service_cost',
            'task',
            'created_at',
        ],
    ]) ?>
    </div>
</div>
</div>


 <div class="box-body table-responsive">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Paid Amount</th>
                            <th>Total Paid</th>
                            <th>Remaining Amount</th>
                          
                            <th>Service Cost</th>

                            <th>Created AT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($all_payments) : ?>
                        <?php foreach($all_payments as $k=>$v) : ?>
                        <tr>
                            <td><?= ($k+1); ?></td>
                            <?php //$paid = $v['paid_amount']+$paid ?>
                            <td><?= $v['paid_amount'];?></td>
                            <td><?= $v['total_paid'];?> </td>
                            <?php $r_amount = $model->service_cost;?>
                            <td><?= $r_amount= $model->service_cost-$v['total_paid'];?></td>
                           
                            <td><?= $model->service_cost?></td>
                            <td><?= $v['created_at'];?></td>
                        </tr>
                        
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-danger text-center">No Payment has been done</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
<?php if(1>0){ ;?>


<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($pay, 'paid_amount')->textInput()->label('Amount'); ?>


    

    <div class="form-group">
        <?= Html::submitButton('pay' , ['class' =>'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><br>
<?php } 

?>