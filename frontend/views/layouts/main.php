<?php
    use common\widgets\Alert;
    use frontend\assets\AppAsset;
use frontend\models\ProductsModel;
use yii\helpers\Html;
    /** @var TYPE_NAME $content */

    AppAsset::register($this);

    $this->registerCssFile('@web/css/output.css?v=' . time(), ['depends' => [\yii\web\YiiAsset::class]]);
    $this->registerJsFile('@web/js/index.js?v=' . time(), ['depends' => [\yii\web\YiiAsset::class]]);

    $theme = $_COOKIE['theme'] ?? 'light';
    $isDark = $theme === 'dark';

    $session = Yii::$app->session;

    if (!$session->isActive) {
        $session->open();
    }

    $userId = Yii::$app->user->identity->id ?? null;
    $userEmail = Yii::$app->user->identity->email ?? null;
    $userRole = Yii::$app->user->identity->role ?? 'guest';
    $first_name = yii::$app->user->identity->first_name ?? null;
    $last_name = yii::$app->user->identity->last_name ?? null;


    $result=[];
    if(yii::$app->user->isGuest){

        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('product')) {
            $productList = json_decode($cookies->getValue('product'), true);
        }

        if(!empty($productList)){
            $productIds = array_keys($productList);
            $product = ProductsModel::find()
                    ->with('restaurant')
                    ->where(['products.id' => $productIds])
                    ->asArray()
                    ->all();
            foreach ($product as $item) {
                $id = $item['id'];
                $item['quantity'] = $productList[$id]['quantity'];
                $wishlistItems[] = $item;
            }

            $result = [];

            foreach ($wishlistItems as $item) {
                $restaurant = $item['restaurant'];
                $restaurantId = $restaurant['id'];

                // Убираем дату создания и обновления у ресторана
                unset($restaurant['created_at'], $restaurant['updated_at']);

                // Подготавливаем данные продукта без вложенного ресторана
                $productData = $item;
                unset($productData['restaurant'], $productData['created_at'], $productData['updated_at']);

                // Если ресторан еще не добавлен в результат
                if (!isset($result[$restaurantId])) {
                    $result[$restaurantId] = $restaurant;
                    $result[$restaurantId]['products'] = [];
                }

                // Добавляем продукт в ресторан
                $result[$restaurantId]['products'][] = $productData;
            }


            $result = array_values($result);


        }

    }else{
        $wishlist = \frontend\models\WishlistsModel::find()
                ->joinWith('product.restaurant')
                ->where(['wishlists.user_id' => $userId])
                ->asArray()
                ->all();



        $result = [];

        foreach ($wishlist as $item) {
            $restaurant = $item['product']['restaurant'];
            $restaurantId = $restaurant['id'];

            $restaurantData = $restaurant;
            unset($restaurantData['created_at'], $restaurantData['updated_at']);

            $productData = $item['product'];
            unset($productData['created_at'], $productData['updated_at'], $productData['restaurant']);
            $productData['quantity'] = $item['quantity'];


            if (!isset($result[$restaurantId])) {
                $result[$restaurantId] = $restaurantData;
                $result[$restaurantId]['products'] = [];
            }

            $result[$restaurantId]['products'][] = $productData;
        }

        $result = array_values($result);

    }





?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="flex flex-col min-h-screen  bg-gray-200 dark:bg-[#191918]">
<?php $this->beginBody() ?>


<header class="flex-shrink-0 fixed top-0 left-0 w-full bg-gray-100 shadow-md dark:bg-[#1f1f1f] dark:shadow-[inset_2px_2px_4px_#141414,inset_-2px_-2px_4px_#1f1f1f] z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="logo flex gap-[10px] md:gap-[20px]  items-center h-full">

            <?= Html::a('Oshoxna.uz', ['restaran/index'], [
                    'class' => 'text-2xl font-bold dark:text-white text-gray-800',
            ]) ?>
            <div class="text-[23px] mt-[10px] dark:text-white">
                <div class="md:hidden">
                    <i class='bxr  bx-search'  ></i>
                </div>
                <div>

                </div>
            </div>
        </div>


        <div class="flex gap-[15px] items-center">
            <label class="toggle toggle-xl text-base-content border-[1px] border-gray-400">
                <input type="checkbox" id="theme-toggle" <?= $isDark ? 'checked="checked"' : '' ?> />
                <i class='bxr bxs-sun bg-white dark:bg-transparent dark:text-white rounded-md text-black'></i>
                <i class='bxr bxs-moon bg-white text-black rounded-md'></i>
            </label>




            <div class="dropdown dropdown-end ">
                <div tabindex="0" role="button" class="  dark:text-white dark:bg-[#1f1f1f] text-[30px]">
                    <i class='bxr  bx-cart'  ></i>
                </div>
                <div tabindex="-1" class="dropdown-content rounded-lg menu bg-white
                    dark:text-white dark:bg-[#1f1f1f] max-h-[500px] p-[10px]  z-1 w-[350px]  shadow-sm overflow-y-auto">
                        <div class="">
                            <?=(
                            \frontend\widgets\WishlistWidget::widget([
                                    'arr' => $result,
                            ])
                            )?>
                        </div>
                </div>

            </div>

            <?php if($userId === null || $userRole === 'guest'):?>
                <?= Html::a('Kirish', ['auth/login'], [
                        'class' => 'dark:text-[#191918] dark:bg-[#FCE000] dark:border-gray-600
                         px-[20px] py-[10px] rounded-lg border border-gray-400
                         bg-white text-gray-800 font-medium
                         shadow-md hover:shadow-lg
                         transition-all duration-150
                         active:translate-y-[2px] active:shadow-sm',
                ]) ?>
            <?php else: ?>


                <div class="relative">
                    <div id="avatar" class="w-[40px] h-[40px] rounded-full cursor-pointer">
                        <img src="<?=(Yii::getAlias('@web'))?>/image/<?= Yii::$app->user->identity->image ?>" class="rounded-full h-[40px] w-[40px]" />
                    </div>


                    <div id="avatar-menu" class="absolute right-0 mt-2 w-40 bg-white dark:bg-[#2c2c2c] rounded-md shadow-lg hidden z-50">
                        <?= Html::a('Profil',
                                ['profile/view' , "id" =>  $userId],
                                [ 'class' =>
                                        'block px-4 py-2 text-gray-800 dark:text-white 
                                        hover:bg-gray-100 dark:hover:bg-gray-700',
                                ])
                        ?>

                        <?php if($userRole === 'owner'):?>

                            <?= Html::a('Restaranlarim', ['owner/index'],[ 'class' => 'block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700',])?>
                        <?php endif;?>

                        <?= Html::a('Buyurtmalarim', ['order/index'],[ 'class' => 'block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700',])?>

                        <?= Html::beginForm(['/auth/logout'], 'post') ?>
                            <?= Html::submitButton('Chiqish', [
                                    'class' => 'block w-full text-left px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 bg-transparent border-none cursor-pointer'
                            ]) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>

            <?php endif;?>
        </div>
    </div>
</header>

<main class="flex-1 container mx-auto px-4 py-6 pt-[88px]">
    <div class="dark:text-white text-gray-800">

        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
