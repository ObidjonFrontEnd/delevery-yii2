<?php

namespace backend\controllers;

class CourierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
