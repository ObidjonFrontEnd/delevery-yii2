<?php

namespace backend\controllers;

use backend\models\Category;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCreate(){
        return $this->render('create');
    }
    public function actionUpdate(){
        return $this->render('update');
    }
    public function actionDelete(){
        return $this->render('delete');
    }
    public function actionView($id){
        $model = Category::findOne($id);

        $this->view->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
        $this->view->params['breadcrumbs'][] = "{$model->name}";
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
