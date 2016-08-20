<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Semester;
use app\models\Calender;
use app\models\Course;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\course\models\BatchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Semesters';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="col-xs-12">
  <div class="col-lg-4 col-sm-4 col-xs-12 no-padding"></div>
  <div class="col-xs-4"></div>
  <div class="col-lg-4 col-sm-4 col-xs-12 no-padding" style="padding-top: 20px !important;">
    <div class="col-xs-4 left-padding">
        <?= Html::button('Add', ['value' => Url::to(['add']), 'title' => 'Add a Semester', 'class' => 'showModalButton btn btn-success btn-block '])?>
    </div>
    <div class="col-xs-4 left-padding">
    <?= Html::a('PDF', ['/export-data/export-to-pdf', 'model'=>get_class($searchModel)], ['class' => 'btn btn-block btn-warning', 'target'=>'_blank']) ?>
    </div>
    <div class="col-xs-4 left-padding">
    <?= Html::a('EXCEL', ['/export-data/export-excel', 'model'=>get_class($searchModel)], ['class' => 'btn btn-block btn-primary', 'target'=>'_blank']) ?>
    </div>
  </div>
</div> -->

    <?php
$gridColumns = [
    [
    'class'=>'kartik\grid\DataColumn',
    'width'=>'15%',
    'attribute'=>'course_id', 
    'value' =>function ($model, $key, $index, $widget) { 
          return $model->course->course_name;
        },
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=>ArrayHelper::map(Course::find()->orderBy('course_name')->asArray()->all(), 'id', 'course_name'), 
    'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Filter Courses'],
    'group'=>true,
    'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
            return [
                'mergeColumns'=>[[0,1],[3,4]], 
                'content'=>[             // content to show in each summary cell
                    0=>'Summary',
                    2=>GridView::F_SUM,
                    5=>GridView::F_SUM,
                    6=>GridView::F_SUM,
                    7=>GridView::F_SUM,

                 ],
                'contentOptions'=>[      // content html attributes for each summary cell
                       0=>['style'=>'font-variant:small-caps'],
                       2=>['style'=>'text-align: left'],
                       5=>['style'=>'text-align: center'],
                       6=>['style'=>'text-align: center'],
                       7=>['style'=>'text-align: center'],
                ],
                // html attributes for group summary row
                'options'=>['class'=>'success','style'=>'font-weight:bold;']
            ];
       } 
    ],
    [  // the Serial column OR the Numpering at the Start
    'class'=>'kartik\grid\DataColumn',
    'attribute'=>'sem_name',
    'group'=>true, 
    'subGroupOf'=>0,
    ],
    [  
    'class'=>'kartik\grid\DataColumn',
    'attribute'=>'no_of_subjects', 
    ],
    [ 
    'attribute' => 'start_date',
    'filter' => \yii\jui\DatePicker::widget([
            'model'=>$searchModel,
            'attribute'=>'start_date',
            'clientOptions' =>[
                'dateFormat' => 'yyyy-mm-dd',
                'changeMonth'=> true,
                'changeYear'=> true,
        'defaultValue'=>null,
        'yearRange'=>'1900:'.(date('Y')+1),
        'defaultDate'=> null,],
         'options'=>[
        'id' => 'start_date',
                'value' => NULL,
        'class'=>'form-control',
                 ],
        ]),
    'format' => 'html', 
    ],
    [
    'attribute' => 'end_date',
    'filter' => \yii\jui\DatePicker::widget([
            'model'=>$searchModel,
            'attribute'=>'end_date',
            'clientOptions' =>[
                'dateFormat' => 'dd-mm-yyyy',
                'changeMonth'=> true,
                'changeYear'=> true,
        'defaultValue'=>null,
        'defaultDate'=> null,
        'yearRange'=>'1900:'.(date('Y')+1),],
         'options'=>[
        'id' => 'end_date',
                'value' => NULL,
        'class'=>'form-control',
                 ],
        ]),
    'format' => 'html', 
    ],
    [  
    'class'=>'kartik\grid\DataColumn',
    'header'=>'Total No Lec', 
    'value' =>function ($model, $key, $index, $widget) { 
          $subjects = $model->subjects ;
            $count = 0;
          foreach ($subjects as $key => $value) { 
            $no_of_lect = $value['no_of_lect'];
            // echo $no_of_lect."<br>";
            $count += $no_of_lect;

          }
          return $count;
        },
    'hAlign'=>'center', 
    'mergeHeader'=>true,
    'pageSummary'=>true,
    'footer'=>true 
    ],
    [  
    'class'=>'kartik\grid\DataColumn',
    'header'=>'Done', 
    'value' =>function ($model, $key, $index, $widget) { 
          $subjects = $model->subjects ;
          $total = 0;
          foreach ($subjects as $key => $value) { // Add less than Current Date , 'date' < date('Y-m-d')
            $count = Calender::find()->where(['sub_id' => $value['id']])->count();
            $total =+ $count;
          }
          return $total;
        },
    'hAlign'=>'center', 
    'mergeHeader'=>true,
    'pageSummary'=>true,
    'footer'=>true 
    ],
    [  
    'class'=>'kartik\grid\FormulaColumn',
    'header'=>'Remaining', 
    'value'=>function ($model, $key, $index, $widget) { 
        $p = compact('model', 'key', 'index');
        return $widget->col(5, $p) - $widget->col(6, $p);//7 & 8 refers to column index
    },
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'hAlign'=>'center', 
    'mergeHeader'=>true,
    'pageSummary'=>true,
    'footer'=>true 
    ],
    [
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => false,
    'vAlign'=>'middle',
    'width'=>'5%',
    'template' => '{view}',
    'buttons' => [
        'view' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>   ', $url, [
                        'title' => 'View',  
            ]);
        },
      ],
      'urlCreator' => function ($action, $model, $key, $index) {
        if ($action === 'view') {
            $url ='index.php?r=semester/view&id='.$model->id;
            return $url;
        }
    }
    
    ],
   
];
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    // 'rowOptions' => [
    //   function($model){
    //                 if($model->expiry == daty('Y-m-d')){
    //                   return ['class'=>'danger'];
    //                 }
    //             }

    // ],
    // 'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
    'toolbar' =>  [
        ['content'=>
         Html::button('', ['value' => Url::to(['add']), 'title' => 'Add a Semester', 'class' => 'showModalButton btn btn-default fa fa-plus'])
        ],
        '{export}',
        '{toggleData}',
    ],
    'pjax' => true,
    'pjaxSettings'=>[
      'neverTimeout'=>true,
        'options'=>
          [
            'id'=>'Semesters',
          ],
    ],
    'bordered' => true,
    'striped' => false,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => true,
    'hover' => true,
   //  // 'floatHeader' => true,
   // // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_INFO,
        'heading' => '<i class="fa fa-2x fa-sitemap"></i><strong>       Manage Semesters</strong>',

    ],
  ]);
  ?>
        
        <?php //echo GridView::widget([
        // 'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // // 'summary'=>'',
        // 'columns' => [
        //     // 'class'=>'kartik\grid\DataColumn',
        //     'attribute'=>'course_id', 
            // 'value' =>function ($model, $key, $index, $widget) { 
            //           return $model->course->course_name;
            //         },
            // 'filterType'=>GridView::FILTER_SELECT2,
            // 'filter'=>ArrayHelper::map(Course::find()->orderBy('course_name')->asArray()->all(), 'id', 'course_name'), 
            // 'filterWidgetOptions'=>[
            //     'pluginOptions'=>['allowClear'=>true],
            // ],
            // 'sem_name',
            // 'no_of_subjects',
            // [
            // 'attribute' => 'start_date',
            // 'filter' => \yii\jui\DatePicker::widget([
            //         'model'=>$searchModel,
            //         'attribute'=>'start_date',
            //         'clientOptions' =>[
            //             'dateFormat' => 'dd-mm-yyyy',
            //             'changeMonth'=> true,
            //             'changeYear'=> true,
            //     'defaultValue'=>null,
            //     'yearRange'=>'1900:'.(date('Y')+1),
            //     'defaultDate'=> null,],
            //      'options'=>[
            //     'id' => 'start_date',
            //             'value' => NULL,
            //     'class'=>'form-control',
            //              ],
            //     ]),
            // 'format' => 'html', 
            // ],
            // [
            // 'attribute' => 'end_date',
            // 'filter' => \yii\jui\DatePicker::widget([
            //         'model'=>$searchModel,
            //         'attribute'=>'end_date',
            //         'clientOptions' =>[
            //             'dateFormat' => 'dd-mm-yyyy',
            //             'changeMonth'=> true,
            //             'changeYear'=> true,
            //     'defaultValue'=>null,
            //     'defaultDate'=> null,
            //     'yearRange'=>'1900:'.(date('Y')+1),],
            //      'options'=>[
            //     'id' => 'end_date',
            //             'value' => NULL,
            //     'class'=>'form-control',
            //              ],
            //     ]),
            // 'format' => 'html', 
            // ],
            // [
            //     'class' => '\pheme\grid\ToggleColumn',
            //     'contentOptions' => ['class' => 'text-center'],
            //     'attribute'=>'is_status',
            //     'enableAjax' => false,
            //     'filter'=>['1'=>'InActive', '0'=>'Active']
            // ], 
        
            // ['class' => 'app\components\CustomActionColumn'],
        // ],
        // ]); ?>
     <?php //\yii\widgets\Pjax::end(); ?>

