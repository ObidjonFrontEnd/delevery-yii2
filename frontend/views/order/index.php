<?php
/** @var array $orders */
/** @var object $pagination */
/** @var yii\data\Sort $sort */
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>

<section class="">
    <!-- Фильтры и сортировка -->
    <div class="mt-[20px] mb-[20px] px-[20px] dark:text-white py-[20px] bg-white rounded-lg gap-[5px] dark:bg-[#1f1f1f] flex items-center justify-between flex-wrap">

        <div class="flex items-center gap-[10px] flex-wrap">
            <a href="<?= Url::to(['order/index']) ?>"
               class="px-4 py-2 rounded-full <?= empty($currentStatus) ? 'bg-yellow-500 text-gray-900' : 'hover:bg-gray-700 hover:text-white' ?> font-semibold whitespace-nowrap">
                Barcha buyurtmalar
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'pending']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'pending' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Kutish holatida
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'confirmed']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'confirmed' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Tasdiqlangan
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'cooking']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'cooking' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Tayyorlanmoqda
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'delivering']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'delivering' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Yetkazib berilmoqda
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'completed']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'completed' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Tugatildi
            </a>

            <a href="<?= Url::to(['order/index', 'status' => 'cancelled']) ?>"
               class="px-4 py-2 rounded-full <?= $currentStatus === 'cancelled' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700 hover:text-white' ?> duration-300 font-medium whitespace-nowrap">
                Bekor qilindi
            </a>
        </div>

        <div class="dropdown dropdown-end">
            <button tabindex="0" role="button" class="ml-auto px-3 py-2 rounded-full bg-gray-700 text-white flex items-center gap-1 hover:bg-gray-600">
                <i class='bxr bx-slider-vertical rotate-90'></i>
                Saralash
            </button>
            <ul tabindex="-1" class="dropdown-content menu text-white dark:bg-[#1f1f1f] bg-gray-700 rounded-box z-1 w-52 p-2 shadow-sm">
                <li>
                    <?= $sort->link('created_at', [
                            'label' => 'Sana bo\'yicha (yangi)',
                            'class' => 'px-4 py-2 text-white rounded-lg transition'
                    ]) ?>
                </li>
                <li>
                    <?= $sort->link('total', [
                            'label' => 'Summaga ko\'ra (qimmatlari)',
                            'class' => 'px-4 py-2 text-white rounded-lg transition'
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>

    <!-- Список заказов -->
    <?php if(isset($orders) && !empty($orders)): ?>
        <div class="grid md:grid-cols-2 sm:grid-cols-2 grid-cols-1 lg:grid-cols-3 gap-[20px]">
            <?php foreach ($orders as $order): ?>
                <div class="bg-white dark:bg-[#2c2c2c] rounded-lg shadow-sm overflow-hidden">
                    <!-- Заголовок заказа -->
                    <div class="px-[20px] py-[15px] border-b border-gray-200 dark:border-gray-700 flex items-center justify-between flex-wrap gap-[10px]">
                        <div class="flex items-center gap-[15px]">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Buyurtma №</p>
                                <p class="font-semibold text-lg"><?= $order->check_number ?? $order->id ?></p>
                            </div>

                            <div class="h-[40px] w-[1px] bg-gray-200 dark:bg-gray-700"></div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Sana</p>
                                <p class="font-medium"><?= Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') ?></p>
                            </div>

                            <div class="h-[40px] w-[1px] bg-gray-200 dark:bg-gray-700"></div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Jami</p>
                                <p class="font-bold text-yellow-500"><?= number_format($order->total, 0, '.', ' ') ?> so'm</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-[10px]">
                            <!-- Статус заказа -->
                            <?php
                            $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'cooking' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                    'delivering' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                            $statusText = [
                                    'pending' => 'Kutish holatida',
                                    'confirmed' => 'Tasdiqlangan',
                                    'cooking' => 'Tayyorlanmoqda',
                                    'delivering' => 'Yetkazib berilmoqda',
                                    'completed' => 'Tugatildi',
                                    'cancelled' => 'Bekor qilindi',
                            ];
                            $statusClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                                <?= $statusText[$order->status] ?? $order->status ?>
                            </span>

                            <!-- Статус оплаты -->
                            <?php
                            $paymentColors = [
                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                            $paymentText = [
                                    'paid' => 'To‘langan',
                                    'pending' => 'To‘lov kutmoqda',
                                    'failed' => 'To‘lanmadi',
                            ];
                            $paymentClass = $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                            ?>
                            <span class="px-3 py-1 rounded-full text-sm font-medium <?= $paymentClass ?>">
                                <?= $paymentText[$order->payment_status] ?? $order->payment_status ?>
                            </span>
                        </div>
                    </div>

                    <!-- Детали заказа -->
                    <div class="px-[20px] py-[15px]">
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-[15px]">
                            <!-- Ресторан -->
                            <?php if(isset($order->restaurant)): ?>
                                <div class="flex items-start gap-[10px]">
                                    <i class='bx bx-store text-[24px] text-gray-400'></i>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Restoran</p>
                                        <p class="font-medium"><?= $order->restaurant->title ?? 'Noma’lum' ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Курьер -->
                            <?php if(isset($order->courier)): ?>
                                <div class="flex items-start gap-[10px]">
                                    <i class='bx bx-user text-[24px] text-gray-400'></i>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kurer</p>
                                        <p class="font-medium">
                                            <?= $order->courier->first_name ?? 'Belgilanmagan' ?>
                                            <?= $order->courier->last_name ?? '' ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Адрес -->
                            <?php if(isset($order->address)): ?>
                                <div class="flex items-start gap-[10px]">
                                    <i class='bx bx-map text-[24px] text-gray-400'></i>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Yetkazib berish manzili</p>
                                        <p class="font-medium"><?= $order->address->name ?? 'Ko‘rsatilmagan' ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Товары -->
                        <?php if(isset($order->orderDetails) && !empty($order->orderDetails)): ?>
                            <div class="mt-[15px] pt-[15px] border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold mb-[10px] text-gray-700 dark:text-gray-300">Mahsulotlar:</p>
                                <div class="space-y-[8px]">
                                    <?php foreach($order->orderDetails as $item): ?>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-[10px]">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            <?= $item->product->name ?? 'Mahsulot' ?> x<?= $item->quantity ?>
                                        </span>
                                            </div>
                                            <span class="font-medium"><?= number_format($item->price * $item->quantity, 0, '.', ' ') ?> so'm</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Кнопки действий -->
                        <div class="mt-[15px] flex items-center gap-[10px] justify-end">
                            <a href="<?= Url::to(['order/view', 'id' => $order->id]) ?>"
                               class="px-4 py-2 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-600 duration-300">
                                Batafsil
                            </a>

                            <?php if($order->status === 'pending'): ?>
                                <a href="<?= Url::to(['order/cancel', 'id' => $order->id]) ?>"
                                   class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 duration-300"
                                   >
                                    Bekor qilish
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="min-h-[80vh] flex flex-col items-center justify-center py-20 text-center text-gray-500 dark:text-gray-400 gap-4">
            <i class='bx bx-shopping-bag text-[80px]'></i>
            <p class="text-xl font-medium">Hozircha buyurtmalar yo‘q</p>
            <a href="<?= Url::to(['restaran/index']) ?>" class="px-6 py-3 bg-yellow-500 text-gray-900 font-semibold rounded-lg hover:bg-yellow-600 duration-300">
                Restoranlarga o‘tish
            </a>
        </div>
    <?php endif; ?>

    <!-- Пагинация -->
    <div class="mt-[20px] flex justify-end">
        <?php
        echo LinkPager::widget([
                "pagination" => $pagination,
                'options' => ['class' => 'flex items-center gap-[10px]'],
                "linkOptions" => ["class" => "border-[1px] rounded-lg h-[40px] w-[40px] border-gray-400 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700 duration-300"],
                'activePageCssClass' => 'bg-yellow-400 rounded-lg border-yellow-400',
                'disabledPageCssClass' => 'hidden',
        ]);
        ?>
    </div>
</section>