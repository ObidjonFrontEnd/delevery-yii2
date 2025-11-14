<?php
/**
 * @var yii\web\View $this
 * @var frontend\models\Order $order
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Buyurtma #' . $order->check_number;
?>

<section class="pb-[40px]">
    <!-- Back Button -->
    <div class="mb-[20px]">
        <?= Html::a(
                '<i class="bx bx-arrow-back text-[20px]"></i> Orqaga qaytish',
                ['index'],
                ['class' => 'inline-flex items-center gap-[10px] px-4 py-2 bg-white dark:bg-[#2c2c2c] rounded-lg hover:bg-gray-100 dark:hover:bg-[#1f1f1f] duration-300 font-medium']
        ) ?>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-[#2c2c2c] rounded-lg shadow-sm overflow-hidden">

        <!-- Header Section -->
        <div class="px-[20px] py-[20px] border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between flex-wrap gap-[15px]">
                <div class="flex items-center gap-[20px] flex-wrap">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Buyurtma №</p>
                        <h1 class="text-2xl font-bold"><?= Html::encode($order->check_number) ?></h1>
                    </div>

                    <div class="h-[50px] w-[1px] bg-gray-200 dark:bg-gray-700"></div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sana</p>
                        <p class="font-medium">
                            <?= Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') ?>
                        </p>
                    </div>

                    <div class="h-[50px] w-[1px] bg-gray-200 dark:bg-gray-700"></div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jami summa</p>
                        <p class="text-2xl font-bold text-yellow-500">
                            <?= number_format($order->total, 0, '.', ' ') ?> so'm
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-[10px] flex-wrap">
                    <?php
                    $statusConfig = [
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'label' => 'Kutish holatida'],
                            'confirmed' => ['class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', 'label' => 'Tasdiqlangan'],
                            'cooking' => ['class' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200', 'label' => 'Tayyorlanmoqda'],
                            'delivering' => ['class' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', 'label' => 'Yetkazib berilmoqda'],
                            'completed' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', 'label' => 'Tugatildi'],
                            'cancelled' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', 'label' => 'Bekor qilindi'],
                    ];

                    $paymentConfig = [
                            'paid' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', 'label' => 'To\'langan'],
                            'pending' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'label' => 'To\'lov kutmoqda'],
                            'failed' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', 'label' => 'To\'lanmadi'],
                    ];

                    $status = $statusConfig[$order->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => $order->status];
                    $payment = $paymentConfig[$order->payment_status] ?? ['class' => 'bg-gray-100 text-gray-800', 'label' => $order->payment_status];
                    ?>

                    <span class="px-3 py-1 rounded-full text-sm font-medium <?= $status['class'] ?>">
                        <?= $status['label'] ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium <?= $payment['class'] ?>">
                        <?= $payment['label'] ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-[20px]">
            <!-- Info Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[20px] mb-[20px]">

                <!-- Restaurant -->
                <?= Html::a(
                        '
                                <div class="bg-gray-50 dark:bg-[#1f1f1f] rounded-lg p-[20px] border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-start gap-[15px]">
                                        <div class="w-[50px] h-[50px] bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bx bx-store text-[28px] text-gray-900"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Restoran</p>
                                            <h3 class="font-bold text-lg mb-2">' . Html::encode($order->restaurant->title) . '</h3>
                                            <div class="space-y-1 text-sm">
                                                <div class="flex items-center gap-[8px] text-gray-600 dark:text-gray-400">
                                                    <i class="bx bx-phone text-[16px]"></i>
                                                    <span class="break-all">' . Html::encode($order->restaurant->phone_number) . '</span>
                                                </div>
                                                <div class="flex items-center gap-[8px] text-gray-600 dark:text-gray-400">
                                                    <i class="bx bx-star text-[16px]"></i>
                                                    <span>Reyting: ' . Html::encode($order->restaurant->rate) . ' / 5.0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ',
                        ['restaran/view', 'id' => $order->restaurant->id], // ссылка
                        ['escape' => false, 'class' => 'block'] // block = кликабельный весь блок
                ) ?>


                <!-- Courier -->
                <div class="bg-gray-50 dark:bg-[#1f1f1f] rounded-lg p-[20px] border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-[15px]">
                        <div class="w-[50px] h-[50px] bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class='bx bx-user text-[28px] text-gray-900'></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Kuryer</p>
                            <h3 class="font-bold text-lg mb-2">
                                <?= Html::encode($order->courier->first_name . ' ' . $order->courier->last_name) ?>
                            </h3>
                            <div class="space-y-1 text-sm">
                                <div class="flex items-center gap-[8px] text-gray-600 dark:text-gray-400">
                                    <i class='bx bx-phone text-[16px]'></i>
                                    <span class="break-all"><?= Html::encode($order->courier->phone_number) ?></span>
                                </div>
                                <div class="flex items-center gap-[8px] text-gray-600 dark:text-gray-400">
                                    <i class='bx bx-car text-[16px]'></i>
                                    <span><?= Html::encode($order->courier->transport_type) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="bg-gray-50 dark:bg-[#1f1f1f] rounded-lg p-[20px] border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-[15px]">
                        <div class="w-[50px] h-[50px] bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class='bx bx-map text-[28px] text-gray-900'></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Yetkazib berish manzili</p>
                            <h3 class="font-bold text-lg mb-2"><?= Html::encode($order->address->name) ?></h3>
                            <div class="space-y-1 text-sm">
                                <div class="flex items-start gap-[8px] text-gray-600 dark:text-gray-400">
                                    <i class='bx bx-home text-[16px] mt-[2px]'></i>
                                    <span>Uy: <?= Html::encode($order->address->house) ?>, Xonadon: <?= Html::encode($order->address->apartment) ?></span>
                                </div>
                                <div class="flex items-start gap-[8px] text-gray-600 dark:text-gray-400 text-xs">
                                    <i class='bx bx-current-location text-[16px] mt-[2px]'></i>
                                    <span class="break-all"><?= Html::encode($order->address->latitude) ?>, <?= Html::encode($order->address->longitude) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-[20px]">
                <div class="flex items-center gap-[10px] mb-[15px]">
                    <i class='bx bx-shopping-bag text-[24px]'></i>
                    <h2 class="text-xl font-bold">Buyurtma mahsulotlari</h2>
                </div>

                <div class="space-y-[15px]">
                    <?php foreach ($order->orderDetails as $detail): ?>

                        <div class="bg-gray-50 dark:bg-[#1f1f1f] rounded-lg p-[15px] border border-gray-200 dark:border-gray-700">

                            <div class="flex items-center justify-between gap-[15px] flex-wrap">
                                <div class="flex items-center gap-[15px] flex-1 min-w-0">
                                    <div class="w-[60px] h-[60px] bg-white dark:bg-[#2c2c2c] rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="<?php Yii::getAlias('@web' )?>/image/<?= Html::encode($detail->product->image) ?>"
                                             alt="<?= Html::encode($detail->product->name) ?>"
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22%3E%3Crect x=%223%22 y=%223%22 width=%2218%22 height=%2218%22 rx=%222%22/%3E%3Ccircle cx=%228.5%22 cy=%228.5%22 r=%221.5%22/%3E%3Cpath d=%22M21 15l-5-5L5 21%22/%3E%3C/svg%3E'">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-lg mb-1 truncate">
                                            <?= Html::encode($detail->product->name) ?>
                                        </h4>
                                        <div class="flex items-center gap-[15px] text-sm text-gray-600 dark:text-gray-400 flex-wrap">
                                            <div class="flex items-center gap-[5px]">
                                                <i class='bx bx-purchase-tag text-[16px]'></i>
                                                <span><?= number_format($detail->product->price, 0, '.', ' ') ?> so'm</span>
                                            </div>
                                            <div class="flex items-center gap-[5px] font-medium">
                                                <i class='bx bx-package text-[16px]'></i>
                                                <span>x<?= Html::encode($detail->quantity) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-yellow-500">
                                        <?= number_format($detail->price, 0, '.', ' ') ?> so'm
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Jami summa</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-[20px] border-2 border-yellow-500 mb-[20px]">
                <div class="flex items-center justify-between flex-wrap gap-[15px]">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Umumiy to'lov</p>
                        <p class="text-3xl font-bold text-yellow-500">
                            <?= number_format($order->total, 0, '.', ' ') ?> so'm
                        </p>
                    </div>
                    <div class="w-[70px] h-[70px] bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class='bx bx-money text-[36px] text-gray-900'></i>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="pt-[20px] border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-[10px] mb-[15px]">
                    <i class='bx bx-time text-[24px]'></i>
                    <h3 class="text-lg font-bold">Tarix</h3>
                </div>
                <div class="space-y-[10px]">
                    <div class="flex items-center gap-[10px] text-sm">
                        <div class="w-[8px] h-[8px] bg-yellow-500 rounded-full flex-shrink-0"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Yaratildi:</span>
                        <span class="text-gray-600 dark:text-gray-400">
                            <?= Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') ?>
                        </span>
                    </div>
                    <div class="flex items-center gap-[10px] text-sm">
                        <div class="w-[8px] h-[8px] bg-yellow-500 rounded-full flex-shrink-0"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Yangilandi:</span>
                        <span class="text-gray-600 dark:text-gray-400">
                            <?= Yii::$app->formatter->asDatetime($order->updated_at, 'php:d.m.Y H:i') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>