<?php

namespace app\controllers;

use Yii;
use app\models\Engineers;
use app\models\Customer;

use app\models\Payment;
use app\models\EngineersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EngineersController implements the CRUD actions for Engineers model.
 */

class EngineersController extends Controller
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
     * Lists all Engineers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EngineersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Engineers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $pay = new Payment();
        $r_amount = '' ;
        $customer = $model->hasOne(Customer::className(), ['id' => 'customer_id']);
            
        
         if ($pay->load(Yii::$app->request->post())){
            $pay->attributes = $_POST['Payment'];
            // $model->id = $_POST['Payment']['id'];
            $pay->engineer_id = $model->id;
            $pay->paid_amount = $_POST['Payment']['paid_amount'];

            $query = (new \yii\db\Query())->from('payment')->where(['engineer_id' => $model->id]);
            $sum = $query->sum('paid_amount');

            
            $pay->total_paid = $sum+$pay->paid_amount;

            if($pay->total_paid <= $model->service_cost) {

            $pay->save();
             
            }$all_payments = (new \yii\db\Query())
                        ->select(['p.created_at', 'p.engineer_id', 'p.paid_amount', 'p.total_paid',  ]) 
                        ->from('payment p')
                        //->join('JOIN', 'p.engineer_id = e.engineer_id')
                        ->where(['p.engineer_id' => $model->id])
                        ->all();

        
                        $pay->paid_amount = '';
            return $this->render('view', ['customer' => $customer, 'model' => $model, 'pay' =>$pay, 'all_payments' => $all_payments, 'r_amount' => $r_amount,]);

         } else {

            $all_payments = (new \yii\db\Query())
                        ->select(['p.created_at', 'p.engineer_id', 'p.paid_amount', 'p.total_paid', ]) 
                        ->from('payment p')
                        //->join('JOIN', 'p.engineer_id = e.engineer_id')
                        ->where(['p.engineer_id' => $model->id])
                        ->all();

            
                return $this->render('view', [ 
                    'customer' => $customer, 'model' => $model, 'pay' =>$pay, 'all_payments' => $all_payments, 'r_amount' => $r_amount,
                ]);
            }
    }

    /**
     * Creates a new Engineers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Engineers();
        $model->customer_id = $_GET['id'] ;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['customer/view', 'id' => $model->customer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Engineers model.
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
     * Deletes an existing Engineers model.
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
     * Finds the Engineers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Engineers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Engineers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
