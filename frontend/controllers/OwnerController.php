<?php

namespace frontend\controllers;


use frontend\models\AddressesModel;
use frontend\models\CategoriesModel;
use frontend\models\ProductDetailModel;
use frontend\models\ProductsModel;
use frontend\models\ProductTagsModel;
use frontend\models\RestauransModel;
use frontend\models\TagsModel;
use frontend\models\UsersModel;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class OwnerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $userID = Yii::$app->user->id;
        $restaurants = UsersModel::findOne($userID);
        $query = $restaurants->getRestaurants();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count , 'pageSize' => 8]);
        $restarans = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index' , [ 'restarans' => $restarans , 'pagination' => $pagination ]);
    }

    public function actionAdd(){
        $insert = new RestauransModel();
        $addresses = ArrayHelper::map(
            AddressesModel::findAll(['user_id' => Yii::$app->session->get('user_id')]),
            'id',
            'name'
        );


        if($insert->load(Yii::$app->request->post()) && $insert->validate()){
            if($insert->save()){
                return $this->redirect(['owner/index']);
            }
        }

        return $this->render('add' , [ 'model' => $insert , 'addresses' => $addresses ]);
    }


    public function actionDelete($id){
        $restaurants = RestauransModel::findOne($id);
        $restaurants->delete();
        return $this->redirect(['owner/index']);
    }


    public function actionEdit($id){
        $restaurants = RestauransModel::findOne($id);
        $addresses = ArrayHelper::map(
            AddressesModel::findAll(['user_id' => Yii::$app->session->get('user_id')]),
            'id',
            'name'
        );
        if($restaurants->load(Yii::$app->request->post()) && $restaurants->validate()){
            if($restaurants->save()){
                return $this->redirect(['owner/index']);
            }
        }
        return $this->render('edit' , [ 'model' => $restaurants , 'addresses' => $addresses ]);
    }

    public function actionAddProduct(){
        $userID = Yii::$app->user->id;
        $productModel = new ProductsModel();
        $productTagModel = new ProductTagsModel();
        $productDetailsModel = new ProductDetailModel();

        $restaurants = RestauransModel::find()
            ->where(['user_id' => $userID])
            ->all();

        $categories = ArrayHelper::map(
            CategoriesModel::find()->all(),
            'id',
            'name'
        );

        $tags = ArrayHelper::map(
            TagsModel::find()->all(),
            'id',
            'name'
        );

        $restaurantList = ArrayHelper::map($restaurants,
            'id',
            'title'
        );

        $selectedTags = [];


            if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $productModel->load(Yii::$app->request->post());

                if ($productModel->validate() && $productModel->save()) {


                    $productDetailsModel->load(Yii::$app->request->post());
                    $productDetailsModel->product_id = $productModel->id;


//                    if (!$productDetailsModel->validate()) {
//                        var_dump($productDetailsModel->errors);
//                        die();
//                    }

                    if (!$productDetailsModel->save()) {
                        throw new \Exception('Failed to save product details');
                    }


                    $selectedTags = Yii::$app->request->post('tags', []);
                    foreach ($selectedTags as $tagId) {
                        $productTag = new ProductTagsModel();
                        $productTag->product_id = $productModel->id;
                        $productTag->tag_id = $tagId;
                        if (!$productTag->save()) {
                            throw new \Exception('Failed to save product tag');
                        }
                    }

                    $transaction->commit();
//                    Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli qo\'shildi!');
                    return $this->redirect(['owner/index']);
                } else {

                    throw new \Exception('ошибки валидации продукта');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
//                Yii::$app->session->setFlash('error', 'Xatolik yuz berdi: ' . $e->getMessage());
            }
        }

            return $this->render('productcontrol', [
                'product' => $productModel,
                'productTag' => $productTagModel,
                'productDetails' => $productDetailsModel,
                'restaurantList' => $restaurantList,
                'categories' => $categories,
                'tags' => $tags,
                'title'=>"Mahsulot qo'shish",
                'selectedTags'=>$selectedTags,

            ]);
    }


    public function actionEditProduct($id)
    {

        $productModel = ProductsModel::findOne(['id' => $id]);
        $userID = Yii::$app->user->id;

        if (!$productModel) {
            throw new \yii\web\NotFoundHttpException('Mahsulot topilmadi');
        }

        // Загружаем существующие детали продукта или создаём новые
        $productDetailsModel = ProductDetailModel::findOne(['product_id' => $id]);
        if (!$productDetailsModel) {
            $productDetailsModel = new ProductDetailModel();
            $productDetailsModel->product_id = $id;
        }


        $existingTags = ProductTagsModel::find()
            ->where(['product_id' => $id])
            ->select('tag_id')
            ->column();


        $restaurants = RestauransModel::find()
            ->where(['user_id' => $userID])
            ->all();


        $categories = ArrayHelper::map(
            CategoriesModel::find()->all(),
            'id',
            'name'
        );

        $tags = ArrayHelper::map(
            TagsModel::find()->all(),
            'id',
            'name'
        );

        $restaurantList = ArrayHelper::map($restaurants, 'id', 'title');

        // Обработка POST запроса
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                // Загружаем данные в модель продукта
                $productModel->load(Yii::$app->request->post());

                if ($productModel->validate() && $productModel->save()) {

                    // Обновляем детали продукта
                    $productDetailsModel->load(Yii::$app->request->post());
                    $productDetailsModel->product_id = $productModel->id;

                    if (!$productDetailsModel->save()) {
                        throw new \Exception('Failed to save product details: ' . json_encode($productDetailsModel->errors));
                    }

                    // ВАЖНО: Удаляем старые связи с тегами
                    ProductTagsModel::deleteAll(['product_id' => $productModel->id]);

                    // Добавляем новые теги
                    $selectedTags = Yii::$app->request->post('tags', []);
                    foreach ($selectedTags as $tagId) {
                        $productTag = new ProductTagsModel();
                        $productTag->product_id = $productModel->id;
                        $productTag->tag_id = $tagId;

                        if (!$productTag->save()) {
                            throw new \Exception('Failed to save product tag: ' . json_encode($productTag->errors));
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli yangilandi!');
                    return $this->redirect(['owner/index']);

                } else {
                    throw new \Exception('Валидация не прошла: ' . json_encode($productModel->errors));
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Xatolik: ' . $e->getMessage());
            }
        }

        return $this->render('productcontrol', [
            'title'=>"Mahsulot tahrirlash",
            'product' => $productModel,
            'productDetails' => $productDetailsModel,
            'restaurantList' => $restaurantList,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $existingTags,
            '$user_id'=>$userID,
        ]);
    }

    public function actionDeleteProduct($id){
        $productModel = ProductsModel::findOne(['id' => $id]);
        $userId = YII::$app->user->id;
        $restaurantId = $productModel->restaurant_id;
        if (!$productModel) {
            throw new \yii\web\NotFoundHttpException('Mahsulot topilmadi');
        }
        if($productModel->delete()){
            return $this->redirect(['restarans/view' , 'id' => $restaurantId]);
        }

    }

}