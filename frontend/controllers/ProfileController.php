<?php

namespace frontend\controllers;





use frontend\models\UsersModel;
use yii\web\Controller;
use yii;

class ProfileController extends Controller
{
    public function actionIndex($id){

//        $user = UsersModel::findOne(['id' => $id]);
//
//        $user->scenario = UsersModel::SCENARIO_UPDATE;
//
//        if ($user->load(Yii::$app->request->post()) && $user->save()) {
//
//            return $this->redirect(['profile/index']);
//        }
//
//        return $this->render('index' , [
//            'model' => $user,
//            ]);
    }


    public function actionView($id){

        $user = UsersModel::findOne(['id' => $id]);

        $user->scenario = UsersModel::SCENARIO_UPDATE;

        if ($user->load(Yii::$app->request->post()) && $user->save()) {

            return $this->redirect(['profile/index']);
        }

        return $this->render('index' , [
            'model' => $user,
        ]);
    }

}