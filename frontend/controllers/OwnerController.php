<?php

namespace frontend\controllers;


use frontend\models\AddressesModel;
use frontend\models\CategoriesModel;
use frontend\models\ProductDetailModel;
use frontend\models\ProductsModel;
use frontend\models\ProductTagsModel;
use frontend\models\RestauransModel;
use frontend\models\TagsModel;
use frontend\models\UserModel;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class OwnerController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['add', 'delete', 'edit', 'addProduct', 'index' , 'editProduct' , 'deleteProduct'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],

            ]
        );
    }

    public function actionIndex()
    {
        $userID = Yii::$app->user->id;
        $restaurants = UserModel::findOne($userID);
        $query = $restaurants->getRestaurants();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count , 'pageSize' => 8]);
        $restarans = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index' , [ 'restarans' => $restarans , 'pagination' => $pagination ]);
    }

    public function actionAdd(){
        $model = new RestauransModel();
        $addresses = ArrayHelper::map(
            AddressesModel::findAll(['user_id' => Yii::$app->user->getId()]),
            'id',
            'name'
        );

        if($model->load(Yii::$app->request->post()) ){
            $model->uploadImage();
            $model->user_id = Yii::$app->user->getId();


            if ($model->save(false)) {
                return $this->redirect(['restaran/view', 'id' => $model->id]);
            }
        }

        return $this->render('add' , [ 'model' => $model , 'addresses' => $addresses ]);
    }


    public function actionDelete($id){
        $restaurants = RestauransModel::findOne($id);
        $restaurants->delete();
        return $this->redirect(['owner/index']);
    }


    public function actionEdit($id){
        $model = RestauransModel::findOne($id);
        $addresses = ArrayHelper::map(
            AddressesModel::findAll(['user_id' => Yii::$app->user->getId()]),
            'id',
            'name'
        );
        if($model->load(Yii::$app->request->post()) ){
            $model->uploadImage();
            $model->user_id = Yii::$app->user->getId();


            if ($model->save(false)) {
                return $this->redirect(['restaran/view', 'id' => $model->id]);
            }
        }
        return $this->render('edit' , [ 'model' => $model , 'addresses' => $addresses ]);
    }

    public function actionAddProduct(){
        $userID = Yii::$app->user->id;
        $productModel = new ProductsModel();
        $productTagModel = new ProductTagsModel();
        $productDetailsModel = new ProductDetailModel();

        $restaurants = RestauransModel::find()->where(['user_id' => $userID])->all();
        $categories = ArrayHelper::map(CategoriesModel::find()->all(), 'id', 'name');
        $tags = ArrayHelper::map(TagsModel::find()->all(), 'id', 'name');
        $restaurantList = ArrayHelper::map($restaurants, 'id', 'title');

        $selectedTags = [];

        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($productModel->load(Yii::$app->request->post())) {

                    // Загрузка изображения (заполняет поле image, но не сохраняет)
                    $productModel->uploadImage();

                    // Валидация и сохранение продукта
                    if ($productModel->save(false)) {

                        // Сохранение деталей продукта
                        $productDetailsModel->load(Yii::$app->request->post());
                        $productDetailsModel->product_id = $productModel->id;

                        if (!$productDetailsModel->save()) {
                            throw new \Exception('Failed to save product details');
                        }

                        // Сохранение тегов
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
                        Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli qo\'shildi!');
                        return $this->redirect(['owner/index']);
                    } else {
                        // Вывод ошибок валидации
                        throw new \Exception('Ошибки валидации: ' . json_encode($productModel->errors));
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Xatolik yuz berdi: ' . $e->getMessage());
            }
        }

        return $this->render('productcontrol', [
            'product' => $productModel,
            'productTag' => $productTagModel,
            'productDetails' => $productDetailsModel,
            'restaurantList' => $restaurantList,
            'categories' => $categories,
            'tags' => $tags,
            'title' => "Mahsulot qo'shish",
            'selectedTags' => $selectedTags,
        ]);
    }


    public function actionEditProduct($id)
    {
        $userID = Yii::$app->user->id;

        $productModel = ProductsModel::findOne(['id' => $id]);
        if (!$productModel) {
            throw new \yii\web\NotFoundHttpException('Mahsulot topilmadi');
        }

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

        $categories = ArrayHelper::map(CategoriesModel::find()->all(),'id','name');
        $tags = ArrayHelper::map(TagsModel::find()->all(),'id','name');
        $restaurantList = ArrayHelper::map($restaurants,'id','title');

        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($productModel->load(Yii::$app->request->post())) {

                    // Загрузка нового изображения если пользователь выбрал другой файл
                    $productModel->uploadImage();

                    if ($productModel->save(false)) {

                        $productDetailsModel->load(Yii::$app->request->post());
                        $productDetailsModel->product_id = $productModel->id;

                        if (!$productDetailsModel->save()) {
                            throw new \Exception('Failed to save product details');
                        }

                        ProductTagsModel::deleteAll(['product_id' => $productModel->id]);

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
                        Yii::$app->session->setFlash('success', 'Mahsulot muvaffaqiyatli yangilandi!');
                        return $this->redirect(['owner/index']);
                    } else {
                        throw new \Exception('Ошибки валидации: ' . json_encode($productModel->errors));
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Xatolik: ' . $e->getMessage());
            }
        }

        return $this->render('productcontrol', [
            'title' => "Mahsulot tahrirlash",
            'product' => $productModel,
            'productDetails' => $productDetailsModel,
            'restaurantList' => $restaurantList,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $existingTags,
            'user_id' => $userID,
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
            return $this->redirect(['restaran/view' , 'id' => $restaurantId]);
        }

    }

}