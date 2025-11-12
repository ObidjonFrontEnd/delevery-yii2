<?php
/** @var frontend\models\WishlistsModel $model */
use yii\helpers\Html;
use yii\helpers\Url;
?>



<div class="max-w-md mx-auto bg-[#111] text-white rounded-2xl shadow-lg overflow-hidden relative p-4 mb-4">
    <!-- Верхняя часть -->
    <div class="flex justify-between items-start mb-3">
        <div>
            <h2 class="font-bold text-lg">
                <?= Html::encode($model->restaurant->title ?? 'Неизвестный ресторан') ?>
            </h2>
            <p class="text-gray-400 text-sm">
                <?= number_format($model->product->price ?? 0, 0, '.', ' ') ?> сум · 20–30 мин
            </p>
        </div>
        <form method="post" action="<?= Url::to(['/wishlist/delete', 'id' => $model->id]) ?>">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                <i class='bx bx-trash text-2xl'></i>
            </button>
        </form>
    </div>

    <!-- Картинка продукта -->
    <div class="flex space-x-2 overflow-x-auto mb-3 scrollbar-hide">
        <img
                src="<?= Yii::getAlias('@web/uploads/products/' . ($model->product->image ?? 'default.jpg')) ?>"
                alt="<?= Html::encode($model->product->name) ?>"
                class="w-20 h-20 rounded-xl object-cover bg-white"
        >
        <!-- если quantity > 1, можно показать дубликаты -->
        <?php if (($model->quantity ?? 1) > 1): ?>
            <?php for ($i = 1; $i < $model->quantity; $i++): ?>
                <img
                        src="<?= Yii::getAlias('@web/uploads/products/' . ($model->product->image ?? 'default.jpg')) ?>"
                        alt="<?= Html::encode($model->product->name) ?>"
                        class="w-20 h-20 rounded-xl object-cover bg-white opacity-90"
                >
            <?php endfor; ?>
        <?php endif; ?>
    </div>

    <!-- Кнопки -->
    <div class="flex justify-between items-center">
        <a href="<?= Url::to(['/restaurant/view', 'id' => $model->product->restaurant_id]) ?>"
           class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            В ресторан
        </a>
        <a href="<?= Url::to(['/cart/add', 'product_id' => $model->product_id]) ?>"
           class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition">
            Оформить заказ
        </a>
    </div>

    <!-- Водяной знак ресторана -->
    <div class="absolute bottom-3 right-3 opacity-10 text-6xl">
        <i class='bx bxs-bowl-hot'></i>
    </div>
</div>
