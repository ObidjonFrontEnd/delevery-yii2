<?php

namespace frontend\controllers;

use frontend\models\ProductDetailModel;
use frontend\models\RestauransModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(){
        $query = ProductDetailModel::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index' , [
            'provider' => $provider,
        ]);
    }
}

