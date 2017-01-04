<?php
namespace console\controllers;

use common\jobhandlers\SendMail;
use shmilyzxt\queue\Worker;
use Yii;

class WorkerController extends \yii\console\Controller
{
    public function actionListen($queueName='default',$attempt=10,$memeory=128,$sleep=3 ,$delay=0){
        Worker::listen(Yii::$app->db_queue,$queueName,$attempt,$memeory,$sleep,$delay);
    }

    public function actionPushOn(){
    	Yii::$app->db_queue->pushOn(new SendMail(),['email'=>'49783121@qq.com','title'=>'test','content'=>'email test'],'default');
    }
}