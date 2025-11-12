<?php
    /* @var $categories array */
    /** @var frontend\controllers\RestaranController $restauran */
    /** @var array $wishlists */


    $this->registerJsFile('@web/js/category-menu.js?v=' . time(), [
            'depends' => [\yii\web\JqueryAsset::class],
    ]);
    $edite = false;
    $userId = Yii::$app->user->identity->id ?? null;
    $userRole = Yii::$app->user->identity->role ?? 'guest';

    if ($userRole == 'owner' && isset($restauran) && !empty($restauran) && $userId == $restauran->user_id) {
        $edite = true;
    }
//    echo "<pre>";
//    print_r($restauran);die();


?>

<div class="container flex-col lg:flex-row  mx-auto p-4 flex gap-6">

<!--     phone da tepa navigatisiya-->
        <div class="lg:hidden mb-6 overflow-x-auto">
        <nav class="flex gap-2 pb-2">
            <?php foreach ($categories as $index => $category): ?>
                <a href="#category-<?= $category['id'] ?>"
                   class="flex-shrink-0 flex items-center gap-2 px-4 py-2 border border-gray-500  text-black dark:text-white rounded-lg transition-all duration-200 hover:bg-gray-700 hover:text-white whitespace-nowrap">
                    <span><?= htmlspecialchars($category['name']) ?></span>
                    <span class="text-xs text-white bg-gray-800 px-2 py-1 rounded-full">
                    <?= count($category['products']) ?>
                </span>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>

<!--    kampyuter va planshetda yon navigatsiya-->
        <div class="hidden lg:block w-64">
            <div class="fixed w-64 bg-white dark:bg-[#1f1f1f] rounded-lg p-4 top-[90px] min-h-[calc(100vh-110px)] overflow-y-auto">
                <nav id="category-menu">
                    <?php foreach ($categories as $index => $category): ?>
                        <a href="#category-<?= $category['id'] ?>"
                           class="category-link flex justify-between items-center px-4 py-3 mb-2 dark:border-none hover:text-white border-gray-500 border-[1px] text-black dark:text-white rounded-lg transition-all duration-200 hover:bg-gray-700"
                           data-category-id="<?= $category['id'] ?>">
                            <span><?= htmlspecialchars($category['name']) ?></span>
                            <span class="text-xs text-white bg-gray-800 px-2 py-1 rounded-full">
                                <?= count($category['products']) ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>

<!--    productlar ni konteynori-->
        <div class="flex-1">

<!--            restaran malumotlari-->
            <div class="mb-[20px]">
                <?php if(isset($restauran) && !empty($restauran) ):?>
                    <div class="bg-white dark:bg-[#1f1f1f] shadow-md rounded-lg overflow-hidden ">
                        <!-- Изображение -->
                        <div class="h-48 w-full bg-gray-200">
                            <img src="<?= Yii::getAlias('@web') . '/image/' . htmlspecialchars($restauran->image) ?>"
                                 alt="<?= htmlspecialchars($restauran->title) ?>" class="w-full h-full object-cover">
                        </div>

                        <!-- Контент -->
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold mb-2 capitalize"><?= htmlspecialchars($restauran->title) ?></h2>

                            <?php if (!empty($restauran->description)): ?>
                                <p class="mt-2 "><?= htmlspecialchars($restauran->description) ?></p>
                            <?php else: ?>
                                <p class="mt-2 text-gray-400 italic text-lg font-semibold mb-2 capitalize">Malumot mavjud emas</p>
                            <?php endif; ?>

                            <div class="mt-4 flex items-center justify-between">

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946a1 1 0 0 0 .95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 0 0-.364 1.118l1.287 3.946c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 0 0-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.287-3.946a1 1 0 0 0-.364-1.118L2.075 9.373c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 0 0 .95-.69l1.286-3.946z"/>
                                    </svg>
                                    <span class="text-lg "><?= $restauran->rate ?></span>
                                </div>


                                <div class="text-lg">
                                    <?= htmlspecialchars($restauran->phone_number) ?>
                                </div>
                            </div>


                        </div>
                    </div>

                <?php endif;?>
            </div>

<!--            productlar-->
            <?php if ( isset($categories) && !empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="mb-8 category-section"
                         id="category-<?= $category['id'] ?? '' ?>"
                         data-category-id="<?= $category['id'] ?>">
                        <h2 class="text-2xl font-bold mb-4 border-b border-b-gray-500 pb-2 capitalize">
                            <?= htmlspecialchars($category['name']) ?>
                        </h2>

                        <?php if (!empty($category['products'])): ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <?php foreach ($category['products'] as $product): ?>
                                    <div class="bg-white dark:bg-[#1f1f1f] shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        <div class="relative">
                                            <img class="w-full h-48 object-cover"
                                                 src="<?= Yii::getAlias('@web') . '/image/' . htmlspecialchars($product['image'] ?? '') ?>"
                                                 alt="<?= htmlspecialchars($product['name'] ?? '') ?>">

                                           <?php if($edite):?>
                                               <div class="absolute top-[20px] right-[20px] flex items-center gap-[5px] flex-col">
                                                   <?= \yii\helpers\Html::beginForm(['owner/delete-product', 'id' => $product['id']],
                                                           'post', ['class' => 'inline']) ?>
                                                       <?= \yii\helpers\Html::submitButton(
                                                               '<i class="bx bxs-trash"></i>',
                                                               [
                                                                       'class' => 'text-red-500 text-[20px] hover:scale-110 
                                                                       transition-transform bg-white dark:bg-[#2c2c2c] rounded-full 
                                                                       h-[38px] w-[38px] flex items-center justify-center shadow-md',
                                                                       'title' => "O'chirish",
                                                                       'onclick' => 'event.stopPropagation();'
                                                               ]
                                                       ) ?>
                                                   <?= \yii\helpers\Html::endForm() ?>


                                                   <?= \yii\helpers\Html::a(
                                                           '<i class="bx bxs-edit"></i>',
                                                           ['owner/edit-product', 'id' => $product['id'] ],
                                                           [
                                                                   'class' => 'text-yellow-400 text-[20px] hover:scale-110 transition-transform bg-white dark:bg-[#2c2c2c] rounded-full h-[38px] w-[38px] flex items-center justify-center shadow-md',
                                                                   'title' => 'Tahrirlash',
                                                                   'onclick' => 'event.stopPropagation();'
                                                           ]
                                                   ) ?>
                                               </div>
                                           <?php endif; ?>
                                        </div>

                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2 capitalize">
                                                <?= htmlspecialchars($product['name'] ?? '') ?>
                                            </h3>
                                            <p class="text-gray-700 dark:text-white mb-2">
                                                Narx: <span class="font-bold">
                                                    <?= ( $product['price'] ? number_format($product['price'], 0, '.', ' ') : "" )  ?> UZS</span>
                                            </p>

                                            <?php if (!empty($product['tags'])): ?>
                                                <div class="mb-2">
                                                    <?php foreach ($product['tags'] as $tag): ?>
                                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1 capitalize">
                                                            <?= htmlspecialchars($tag['tag_name']) ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                            if (is_array($product['prodcutDetails']) && !empty(array_filter($product['prodcutDetails']))) {

                                                $filteredDetails = array_diff_key(
                                                        $product['prodcutDetails'],
                                                        array_flip(['id', 'product_id', 'created_at', 'updated_at'])
                                                );
                                                ?>
                                                <?php if (!empty(array_filter($filteredDetails))): ?>
                                                    <ul class="text-gray-600 text-sm">
                                                        <?php foreach ($filteredDetails as $key => $value): ?>
                                                            <?php if ($value): ?>
                                                                <li class="dark:text-white">
                                                                    <span class="font-semibold">
                                                                        <?= ucfirst(str_replace('_', ' ', $key)) ?>:
                                                                    </span>
                                                                    <?= htmlspecialchars($value) ?>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            <?php } ?>



                                            <div class="mt-[10px]">



                                                    <?php if (isset($wishlists[$product['id']])): ?>
                                                       <div class="flex justify-end gap-[10px] w-full items-center">
                                                           <div>
                                                               <?= \yii\helpers\Html::beginForm(
                                                                       ['restaran/delete-product-wishlist'],
                                                                       'post',
                                                                       ['class' => 'inline']
                                                               ) ?>
                                                                    <?=( \yii\helpers\Html::input('hidden', 'id',  $wishlists[$product['id']]['id'] ) ) ?>
                                                                   <?= \yii\helpers\Html::submitButton(
                                                                           '-',
                                                                           [
                                                                                   'class' => 'border-[1px] border-gray-700 rounded-lg px-[15px] hover:dark:bg-gray-700
                                                                                                hover:bg-[#1f1f1f] duration-300 hover:text-white py-[10px]',
                                                                                   'title' => 'Уменьшить количество'
                                                                           ]
                                                                   ) ?>
                                                               <?= \yii\helpers\Html::endForm() ?>
                                                           </div>
                                                           <div class="">
                                                               <p class="px-[15px] py-[10px]">
                                                                   <?= $wishlists[$product['id']]['quantity'] ?>
                                                               </p>
                                                           </div>
                                                           <div>
                                                               <?= \yii\helpers\Html::beginForm(['restaran/add-product-wishlist'], 'post') ?>
                                                               <?= \yii\helpers\Html::hiddenInput('WishlistsModel[product_id]', $product['id']) ?>
                                                               <?= \yii\helpers\Html::hiddenInput('WishlistsModel[user_id]', $userId) ?>
                                                               <?= \yii\helpers\Html::hiddenInput('WishlistsModel[quantity]', 1) ?>
                                                               <?=(yii\helpers\Html::submitButton(
                                                                       '+',
                                                                       [
                                                                               'class' => 'border-[1px] border-gray-700 rounded-lg px-[15px] hover:dark:bg-gray-700
                                                                                    hover:bg-[#1f1f1f] duration-300 hover:text-white py-[10px]'
                                                                       ]
                                                               ))?>
                                                               <?=(yii\helpers\Html::endForm())?>
                                                           </div>
                                                       </div>
                                                    <?php else: ?>
                                                        <?= \yii\helpers\Html::beginForm(['restaran/add-product-wishlist'], 'post') ?>
                                                            <?= \yii\helpers\Html::hiddenInput('WishlistsModel[product_id]', $product['id']) ?>
                                                            <?= \yii\helpers\Html::hiddenInput('WishlistsModel[user_id]', $userId) ?>
                                                            <?= \yii\helpers\Html::hiddenInput('WishlistsModel[quantity]', 1) ?>
                                                            <?=(yii\helpers\Html::submitButton(
                                                                    "Savatga Qo'shish",
                                                                    [
                                                                            'class' => 'border-[1px] border-gray-700 rounded-lg w-full hover:dark:bg-gray-700
                                                                                hover:bg-[#1f1f1f] duration-300 hover:text-white py-[10px]'
                                                                    ]
                                                            ))?>
                                                        <?=(yii\helpers\Html::endForm())?>
                                                    <?php endif; ?>



                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 italic">Mahsulotlar mavjud emas.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="flex items-center h-[80vh] justify-center text-bold text-[25px]">
                    <p class="text-gray-500 italic text-center">Bu restaranda hali mahsulotlar mavjud emas</p>
                </div>
            <?php endif; ?>
        </div>

</div>