<?php

namespace backend\controllers;

use backend\models\Category;
use backend\models\Orders;
use backend\models\Products;
use backend\models\Restaurant;
use common\models\LoginForm;
use frontend\models\Order;
use frontend\models\OrderDetails;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'layout' => 'blank',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($year = null)
    {


        if ($year === null) {
            $year = date('Y');
        }

        // Валидация года
        $year = (int)$year;
        if ($year < 2000 || $year > date('Y')) {
            $year = date('Y');
        }


        $availableYears = Orders::find()
            ->select([new \yii\db\Expression('DISTINCT YEAR(created_at) as year')])
            ->where(['IS NOT', 'created_at', null])
            ->orderBy(['year' => SORT_DESC])
            ->column();

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $orderDetails = OrderDetails::find()
            ->with('product.category')
            ->with('product.restaurant')
            ->where(['YEAR(created_at)' => $year])
            ->asArray()
            ->all();

        $orders = Orders::find()
            ->select([
                'month' => new \yii\db\Expression('MONTH(created_at)'),
                'count' => new \yii\db\Expression('COUNT(*)'),
                'total' => new \yii\db\Expression('SUM(total)'),
            ])
            ->where(['YEAR(created_at)' => $year])
            ->groupBy(new \yii\db\Expression('MONTH(created_at)'))
            ->asArray()
            ->all();

        $total = Orders::find()
            ->where(['YEAR(created_at)' => $year])
            ->sum('total');


//        echo '<pre>';
//        print_r($orderDetails);
//        die();

        return $this->render('index', [
            'orderDetails' => $orderDetails,
            'total' => $total,
            'orders' => $orders,
            'currentYear' => $year,
            'availableYears' => $availableYears,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
