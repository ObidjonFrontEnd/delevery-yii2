<?php

namespace frontend\controllers;


use frontend\models\CategoriesModel;
use frontend\models\RestauransModel;
use yii\web\Cookie;
use frontend\models\WishlistsModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class RestaranController extends Controller
{



    public function actionIndex($category = null)
    {

        $categories = CategoriesModel::find()->limit(8)->all();
        $categories2 = CategoriesModel::find()->offset(8)->all();
        $id = $category;

        $query = RestauransModel::find();

        if(isset($id) && !empty($id)){
            $query
            ->joinWith('products')
            ->where(['products.category_id' => $id]);
        }


        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false,
            ]
        ]);

        $restaurants = $provider->getModels();
        $pagination = $provider->getPagination();
        $sort = $provider->getSort();


        return $this->render('index' , [
            'restarans' => $restaurants ,
            'categories' => $categories ,
            'categories2' => $categories2 ,
            'pagination' => $pagination,
            'sort' => $sort,
            'category_id'=>$id,
        ]);
    }

    public function actionView($id)
    {
        \yii\helpers\Url::remember();
        $id = Yii::$app->request->get('id');
        $restauran = RestauransModel::findOne($id);
        $requestCookies = Yii::$app->request->cookies;

        if(yii::$app->user->isGuest){

            $wishlists = [];

            if ($requestCookies->has('product')) {
                $wishlists = json_decode($requestCookies->getValue('product'), true);
            }
        }else{
            $wishlists = WishlistsModel::find()->where(['user_id' => Yii::$app->user->id])-> indexBy('product_id')->asArray()->all();
        }




        if (!$restauran) {
            Yii::$app->session->setFlash('error', 'Restoran topilmadi');
            return $this->redirect(['restarans/index']);
        }

        $products = CategoriesModel::find()
            ->joinWith('products.productTags.tags' )
            ->joinWith('products.prodcutDetails' )
            ->where(['products.restaurant_id' => $id])
            ->asArray()
            ->all();

//        prd($products);




        return $this->render('view', ['categories' => $products , 'restauran' => $restauran , 'wishlists' => $wishlists]);
    }

    public function actionAddProductWishlist()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $postData = $request->post();

            $userId = Yii::$app->user->id;
            $productId = $postData['WishlistsModel']['product_id'] ?? null;

            if(yii::$app->user->isGuest){
                $this->actionAddToCookie($productId);

            }else{
                if ($productId) {

                    $wishlistItem = WishlistsModel::find()
                        ->where(['user_id' => $userId, 'product_id' => $productId])
                        ->one();

                    if ($wishlistItem) {

                        $wishlistItem->quantity += 1;
                        $wishlistItem->save(false);
                    } else {

                        $model = new WishlistsModel();
                        $model->user_id = $userId;
                        $model->product_id = $productId;
                        $model->quantity = 1;
                        $model->save();
                    }

                    return $this->goBack();
                }
            }


        }
    }

    public function actionAddToCookie($id)
    {
        $cookies = Yii::$app->request->cookies;
        $responseCookies = Yii::$app->response->cookies;

        $products = [];

        if ($cookies->has('product')) {
            $products = json_decode($cookies->getValue('product'), true);
        }


        if (isset($products[$id])) {
            $products[$id]['quantity'] += 1;
        } else {
            $products[$id] = [
                'id' => $id,
                'quantity' => 1
            ];
        }

        // Сохраняем массив обратно в cookie
        $responseCookies->add(new Cookie([
            'name' => 'product',
            'value' => json_encode($products),
            'expire' => time() + 3600 * 24 * 30, // 30 дней
        ]));

        return $this->goBack();
    }



    public function actionDeleteProductWishlist(){


        $id = Yii::$app->request->post('id');

        if (!$id) {
            throw new \yii\web\BadRequestHttpException('Product Id Kelmadi');
        }

        if(yii::$app->user->isGuest){

            $this->actionDeleteProductAtCookies($id);

        }else{

            $model = WishlistsModel::findOne($id);

            if ($model->quantity > 1) {
                $model->quantity = $model->quantity - 1;
                $model->save();
                return $this->goBack();
            }else{
                $model->delete();
                return $this->goBack();
            }

        }



    }

    public function actionDeleteProductAtCookies($id){
        $requestCookies = Yii::$app->request->cookies;
        $responseCookies = Yii::$app->response->cookies;

        $products = [];

        if ($requestCookies->has('product')) {
            $products = json_decode($requestCookies->getValue('product'), true);
        }


        if (isset($products[$id])) {
            if ($products[$id]['quantity'] > 1) {
                $products[$id]['quantity'] -= 1;
            } else {
                unset($products[$id]);
            }
        }


        $responseCookies->add(new Cookie([
            'name' => 'product',
            'value' => json_encode($products),
            'expire' => time() + 3600 * 24 * 30,
        ]));

        return $this->goBack();
    }

}