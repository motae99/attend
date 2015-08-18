<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Engineers;
use app\models\EngineersSearch;

use app\models\Spare;
use app\models\SpareSearch;

use yii\helpers\ArrayHelper;


/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd($id)
    {
         $model = $this->findModel($id);
         $eng = new Engineers();
         $sp = new Spare();
         $cid = $model->id;
         $eng->customer_id = $cid;
         $sp->customer_id = $cid;


        if ($eng->load(Yii::$app->request->post()) && $eng->save()) {
            $engin = (new \yii\db\Query())
            ->select(['e.created_at', 'e.name', 'e.phone_no', 'e.service_cost', 'e.task']) 
            ->from('engineers e')
            ->join('JOIN', 'customer c', 'c.id = e.customer_id')
            ->where(['c.id' => $cid])
            ->all();

            $spa = (new \yii\db\Query())
            ->select(['s.created_at', 's.spare_name', 's.part_number', 's.price', ]) 
            ->from('spare s')
            ->join('JOIN', 'customer c', 'c.id = s.customer_id')
            ->where(['c.id' => $cid])
            ->all();

            $sp = new Spare();
            $eng = new Engineers();
            return $this->render('add', [
                'model' => $model, 'engin'=>$engin, 'eng' => $eng, 'sp' => $sp, 'spa' => $spa,
            ]);
        } elseif ($sp->load(Yii::$app->request->post()) && $sp->save()){
            $engin = (new \yii\db\Query())
            ->select(['e.created_at', 'e.name', 'e.phone_no', 'e.service_cost', 'e.task']) 
            ->from('engineers e')
            ->join('JOIN', 'customer c', 'c.id = e.customer_id')
            ->where(['c.id' => $cid])
            ->all();

             $spa = (new \yii\db\Query())
            ->select(['s.created_at', 's.spare_name', 's.part_number', 's.price', ]) 
            ->from('spare s')
            ->join('JOIN', 'customer c', 'c.id = s.customer_id')
            ->where(['c.id' => $cid])
            ->all();
        
            $sp = new Spare();
            $eng = new Engineers();
            return $this->render('add', [
                'model' => $model, 'engin'=>$engin, 'eng'=>$eng, 'sp' => $sp, 'spa' => $spa,
            ]);
        } else {
             $engin = (new \yii\db\Query())
            ->select(['e.created_at', 'e.name', 'e.phone_no', 'e.service_cost', 'e.task']) 
            ->from('engineers e')
            ->join('JOIN', 'customer c', 'c.id = e.customer_id')
            ->where(['c.id' => $cid])
            ->all();


             $spa = (new \yii\db\Query())
            ->select(['s.created_at', 's.spare_name', 's.part_number', 's.price', ]) 
            ->from('spare s')
            ->join('JOIN', 'customer c', 'c.id = s.customer_id')
            ->where(['c.id' => $cid])
            ->all();
        
            return $this->render('add', [
                'model' => $model, 'engin'=>$engin, 'eng'=>$eng, 'sp' => $sp, 'spa' => $spa,
            ]);
        }
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $cus_id = $model->id;
        //StuGuardians::find()->where('guardia_stu_master_id ='.$model->stu_master_id.' AND stu_guardian_id = '.$_REQUEST['stu_guard_id'])->one();

       // $eng = new Engineers();
       // $eng = (Engineers::className(), ['customer_id' => $model->id]);
        $eng = Engineers::find()->where('customer_id' == $cus_id)->all  ();
        return $this->render('view', [
            'eng' => $eng, 'model' => $model, 
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
