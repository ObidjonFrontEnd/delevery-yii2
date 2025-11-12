<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $arr */
?>

<?php foreach ($arr as $restaurant): ?>
    <div class="bg-[#1a1a1a] text-white rounded-2xl shadow-lg overflow-hidden p-4 mb-4 relative">
        <!-- Заголовок и цена -->
        <div class="flex justify-between items-start mb-3">
            <div>
                <h2 class="font-bold text-xl mb-1">
                    <?= Html::encode($restaurant['title'] ?? 'Неизвестный ресторан') ?>
                </h2>
                <p class="text-gray-400 text-sm">
                    <?php
                    if (!empty($restaurant['products'])) {
                        $totalPrice = 0;
                        foreach ($restaurant['products'] as $product) {
                            $quantity = $product['quantity'] ?? 1;
                            $price = $product['price'] ?? 0;
                            $totalPrice += $price * $quantity;
                        }
                        echo number_format($totalPrice, 0, '', ' ') . "so'm · 20 – 30 мин";
                    }
                    ?>
                </p>
            </div>

            <button class="text-gray-400 hover:text-white transition p-2">
                <i class='bx bx-trash text-2xl'></i>
            </button>
        </div>

        <!-- Продукты с бейджами количества -->
        <div class="flex items-center gap-3 mb-4 overflow-x-auto scrollbar-hide py-2">
            <?php if (!empty($restaurant['products'])): ?>
                <?php
                $visibleProducts = array_slice($restaurant['products'], 0, 2);
                $remainingCount = count($restaurant['products']) - 2;
                ?>

                <?php foreach ($visibleProducts as $product): ?>
                    <div class="relative flex-shrink-0">
                        <div class="w-20 h-20 bg-white rounded-2xl overflow-hidden">
                            <img
                                    src="<?= Yii::getAlias('@web/image/' . ($product['image'] ?? 'default.jpg')) ?>"
                                    alt="<?= Html::encode($product['name'] ?? 'Продукт') ?>"
                                    class="w-full h-full object-cover"
                            >
                        </div>
                        <!-- Бейдж количества -->
                        <div class="absolute -top-1 -right-1 bg-yellow-400 text-black text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg">
                            <?= $product['quantity'] ?? 1 ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($remainingCount > 0): ?>
                    <div class="flex-shrink-0 w-20 h-20 bg-[#2a2a2a] rounded-2xl flex items-center justify-center">
                        <span class="text-gray-400 text-lg font-semibold">+<?= $remainingCount ?></span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Кнопки -->
        <div class="flex gap-3">
            <a href="<?= Url::to(['/restaran/view', 'id' => $restaurant['id'] ?? 0]) ?>"
               class="flex-1 bg-[#2a2a2a] text-white px-6 py-[3px] flex items-center justify-center rounded-xl hover:bg-[#333] transition text-center font-medium">
                Restoranga
            </a>
            <a href="<?= Url::to(['/cart/add-from-wishlist', 'restaurant_id' => $restaurant['id'] ?? 0]) ?>"
               class="flex-1 bg-yellow-400 text-black px-6 py-[3px] flex items-center justify-center rounded-xl hover:bg-yellow-300 transition text-center font-semibold">
                Buyurtma bering
            </a>
        </div>
    </div>
<?php endforeach; ?>