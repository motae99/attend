<?php

namespace app\controllers;

use Yii;
use app\models\Attendance;
use app\models\Student;
use app\models\Subjects;
use app\models\Calender;
use app\models\AttendanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Attend;
use app\components\Devices;


/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Attendance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttendanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attendance model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionReport()
    {
        return $this->render('report');
    }

    public function actionGeneric($no)
    {   
        if($no == 1){
            $ip = '192.168.1.201';
        }elseif($no == 2) {
            $ip = '192.168.1.202';
        }
        $port = 4370; 

        $attend = new Devices($ip, $port);
        $connection = $attend->connection();
        if($connection){
            $dis = $attend->disable();
            // $logs = $attend->getlogs();
            // var_dump($logs);
            // $users = (new \yii\db\Query())
            //         ->select('*')
            //         ->from('users')
            //         ->where(['id' => '1'])
            //         ->all();
             // var_dump($users);
                    //'in', 'id', [1 ,2, 3, 4, 5, 6, 7, 8, 9, 10]
                    //'between', 'id', 0 , 799
            // foreach ($users as $user => $value) {
            //     // echo $value['id']. " ".$value['uid']." ".$value['name']."<br>";
            //     $pass = "";
            //     $role = 0;
            //     sleep(1);
            //     $set = $attend->setUsers($value['id'], $value['uid'], $value['name'], $pass, $role);

            // }


            // $clear = $attend->clearLogs();
            $devUsers = $attend->allUsers();
            // // var_dump($users);
            // // $clearUsers = $attend->clearUsers();
            foreach ($devUsers as $key => $v) {
                echo $v[0]. " ".$v[1]." ".$v[2]." ".$v[3]."<br>";
            }

            $attend->enable();
            $cutConnection = $attend->disConnection();
        }


    }

    public function actionSync()
    {
        $attend = new Attend();
        $connection = $attend->connect();
        if($connection){
        
        $dis = $attend->disable();
        $logs = $attend->getlogs();
        // var_dump($logs);

        sleep(2);
            foreach ($logs as $log => $k) {
                echo $log." ".$k[1]." ".$k[3]."<br>";
                // echo $log." ".$k[1]." ".$k[3]."<br>";
                // echo "id on device: ".$k[1]."<br>";
                // echo "timestamp of log: ".$k[3]."<br>";
                // $student = Student::find()->where(['id' =>$k[1]])->one();
                // echo "id on sys: ".$student->id."<br>";
                // echo "sem id : ".$student->sem_id."<br>";
                // echo "student Name: ".$student->name."<br>";
                // echo "<br> <br>";
                // $sem = $student->sem_id;
                // echo $sem;
                // $sub = Subjects::find()->where(['sem_id'=>$sem])->all();
                // var_dump($sub);
                // foreach ($sub as $s => $v) {
                //     // echo " Subject id :".$v['id']."<br> ";
                //     // echo " Semester id  :".$v['sem_id']."<br> ";
                //     // echo " sub_name :".$v['sub_name']."<br> ";
                //     // echo " noOfLec :".$v['no_of_lect']."<br> ";
                //     // echo "<br> " ;
                //     $cal = Calender::find()->where(['sub_id'=>$v['id']])->all();
                //     foreach ($cal as $c => $value) {
                //         $start = $value['date']." ".$value['start_time'];
                //         $end = $value['date']." ".$value['end_time'];
                //         // echo $start." to ".$end."<br>";
                //         // echo $k[3]."<br>"; 
                //         if($k[3] >= $start && $k[3] <= $end){
                //             // echo "student attended this: <br> ";
                //             // echo $start." to ".$end."<br>";
                //             // echo "timestamp of log: ".$k[3]."<br> <br>";
                //             $mark = new Attendance();
                //             $mark->sub_id = $value['sub_id'];
                //             $mark->stu_id = $student->id;
                //             $mark->time_table_id = $value['id'];
                //             $mark->status = 1;
                //             // $mark->save();
                            
                            
                //         }
                //     }
                // }
            }
           



        // Need to Clear Attandence Logs from Device 
        // $clear = $attend->clearLogs();
        // var_dump($clear);
        
        
            $attend->enable();
            $cutConnection = $attend->disConnection();
        }
    

        // return $this->redirect(['index']);
        
    }

    public function actionClear(){
        $attend = new Attend();
        $clear = $attend->clearLogs();

    }

    /**
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attendance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Attendance model.
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
     * Deletes an existing Attendance model.
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
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
