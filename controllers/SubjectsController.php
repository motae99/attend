<?php

namespace app\controllers;

use Yii;
use app\models\Subjects;
use app\models\Calender;
use app\models\Semester;
use app\models\SubjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubjectsController implements the CRUD actions for Subjects model.
 */
class SubjectsController extends Controller
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
     * Lists all Subjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subjects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSem($id)
    {
        $rows = Semester::find()->where(['course_id' => $id])->all();
     
        echo "<option value=''>---Select Sem---</option>";
     
        if(count($rows)>0){
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->sem_name</option>";
            }
        }
        else{
            echo "";
        }
 
        }

    /**
     * Creates a new Subjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subjects();

        if ($model->load(Yii::$app->request->post()) ) {
            $subName = $_POST['Subjects']['sub_name'];
            $sem_id = $_POST['Subjects']['sem_id'];
            $sem = Semester::find()->where(['id' => $sem_id])->one();
            $starting_date = $sem->start_date;
            $ending_date = $sem->end_date;
            $noOfLec = $_POST['Subjects']['no_of_lect'];
            $days = array();
            $time = array();
            $model->save(false);


            if(isset($_POST['Subjects']['sat_start_time']) && isset($_POST['Subjects']['sat_end_time'])){
                $days[] = 6 ; 
                $time[6]['start'] = $_POST['Subjects']['sat_start_time'];
                $time[6]['end'] = $_POST['Subjects']['sat_end_time'];

                
            }
            if(isset($_POST['Subjects']['sun_start_time']) && isset($_POST['Subjects']['sun_end_time'])){
                $days[] = 0 ;
                $time[0]['start'] = $_POST['Subjects']['sun_start_time'];
                $time[0]['end'] = $_POST['Subjects']['sun_end_time'];


            }
            if(isset($_POST['Subjects']['mon_start_time']) && isset($_POST['Subjects']['mon_end_time'])){
                $days[] = 1 ;
                $time[1]['start'] = $_POST['Subjects']['mon_start_time'];
                $time[1]['end'] = $_POST['Subjects']['mon_end_time'];

            }
            if(isset($_POST['Subjects']['tue_start_time']) && isset($_POST['Subjects']['tue_end_time'])){
                $days[] = 2 ;
                $time[2]['start'] = $_POST['Subjects']['tue_start_time'];
                $time[2]['end'] = $_POST['Subjects']['tue_end_time'];
            }
            if(isset($_POST['Subjects']['wen_start_time']) && isset($_POST['Subjects']['wen_end_time'])){
                $days[] = 3 ;
                $time[3]['start'] = $_POST['Subjects']['wen_start_time'];
                $time[3]['end'] = $_POST['Subjects']['wen_end_time'];


            }
            if(isset($_POST['Subjects']['the_start_time']) && isset($_POST['Subjects']['the_end_time'])){
                $days[] = 4 ;
                $time[4]['start'] = $_POST['Subjects']['the_start_time'];
                $time[4]['end'] = $_POST['Subjects']['the_end_time'];


            }

            $current = strtotime($starting_date);
            $last = strtotime($ending_date);
            $i = 1;
            $dates = array();

            while( $current <= $last && $i <= $noOfLec) {

                $day = date('Y-m-d', $current);
                // echo $day."<br>";
                $dayofweek = date('w', strtotime($day));
                // echo $dayofweek."<br>";
                if (in_array($dayofweek, $days))
                 {
                    // $dates[] = date('Y-m-d', $current);
                    $dates[$i]['sub_id'] = $model->id;
                    $dates[$i]['day']  = $dayofweek;
                    $dates[$i]['date'] = date('Y-m-d', $current);
                    $dates[$i]['start_time'] = $time[$dayofweek]['start'];
                    $dates[$i]['end_time'] = $time[$dayofweek]['end'];
             //    echo $model->id."<br>";
             // echo $dayofweek."<br>";
             //  echo date('Y-m-d', $current)."<br>";
             //        echo $time[$dayofweek]['start']."<br>";
                 // echo Yii::$app->formatter->asTime($time[$dayofweek]['start'])."<br>";
                 // echo "<br>";
                 // echo Yii::$app->formatter->asTime($time[$dayofweek]['end'])."<br>";
                 // echo "<br>";
             //        
                    $i++;
                 }

                $current = strtotime('+1 day', $current);
            }
            // var_dump($dates);
            foreach ($dates as $date => $v) {
                $cal = new Calender();
                $cal->sub_id = $v['sub_id'];
                $cal->day = $v['day'];
                $cal->date = $v['date'];
                $cal->start_time = $v['start_time'];
                $cal->end_time = $v['end_time'];
                $cal->save(false);
            }
             return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Subjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAdd($sem_id){
        $model = new Subjects();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('_add', [
                'model' => $model,
            ]);

        
        }
    }

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
     * Deletes an existing Subjects model.
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
     * Finds the Subjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
