<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UsersModel */

$this->title = 'krish';
?>

<div class="h-[80vh] flex items-center justify-center  dark:bg-[#191918]">
    <div class="w-full max-w-md bg-white dark:bg-[#1f1f1f] shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'space-y-4'],
            'fieldConfig' => [
                'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
            ],
        ]); ?>

        <?= $form->field($model, 'email', [
            'inputOptions' => [
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Email',
            ],
        ])->label(false) ?>

        <?= $form->field($model, 'password', [
            'inputOptions' => [
                'type' => 'password',
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-[#2c2c2c] dark:text-white',
                'placeholder' => 'Parol',
            ],
        ])->label(false) ?>

        <div class="flex items-center justify-between">
            <?= Html::submitButton('Kirish', [
                'class' => 'bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-black font-semibold py-2 px-4 rounded-md w-full transition duration-200',
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <p class="mt-4 text-center text-gray-600 dark:text-gray-300 text-sm">
           Ro'yhatdan o'tmaganmisiz? <?= Html::a("Ro'yhatdan o'tish", ['auth/signup'], ['class' => 'text-yellow-400 hover:text-yellow-500']) ?>
        </p>
    </div>
</div>
