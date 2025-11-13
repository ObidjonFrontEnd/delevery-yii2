<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Order $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = "Buyurtma qo‘shish / tahrirlash";
?>

<div class="min-h-[80vh] py-[10px] flex items-center justify-center dark:bg-[#191918]">
    <div class="w-full max-w-md bg-white dark:bg-[#1f1f1f] shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">
            <?= Html::encode($this->title) ?>
        </h1>

        <?php $form = ActiveForm::begin([
                'id' => 'order-form',
                'options' => ['class' => 'space-y-4'],
                'fieldConfig' => [
                        'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
                ],
        ]); ?>

        <?= $form->field($model, 'user_id')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Foydalanuvchi ID',
        ])->label(false) ?>

        <?= $form->field($model, 'restaurant_id')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Restoran ID',
        ])->label(false) ?>

        <?= $form->field($model, 'courier_id')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Kuryer ID',
        ])->label(false) ?>

        <?= $form->field($model, 'total')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Umumiy summa',
        ])->label(false) ?>

        <?= $form->field($model, 'check_number')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Check raqami',
        ])->label(false) ?>

        <?= $form->field($model, 'status')->dropDownList([
                'pending' => 'Kutilmoqda',
                'accepted' => 'Qabul qilindi',
                'delivering' => 'Yetkazilmoqda',
                'completed' => 'Yakunlandi',
                'cancelled' => 'Bekor qilindi',
        ], [
                'prompt' => 'Buyurtma holatini tanlang',
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-gray-300 cursor-pointer',
        ])->label(false) ?>

        <?= $form->field($model, 'payment_status')->dropDownList([
                'unpaid' => 'To‘lanmagan',
                'paid' => 'To‘langan',
        ], [
                'prompt' => 'To‘lov holatini tanlang',
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-gray-300 cursor-pointer',
        ])->label(false) ?>

        <?= $form->field($model, 'address_id')->textInput([
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Manzil ID',
        ])->label(false) ?>

        <div class="flex justify-center pt-4">
            <?= Html::submitButton('💾 Saqlash', [
                    'class' => 'bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 
                    text-gray-900 dark:text-black font-semibold py-2 px-6 rounded-md w-full transition duration-200',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
