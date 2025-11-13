<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\OrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-search bg-white p-4 rounded-xl shadow mb-6">

    <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                    'data-pjax' => 1,
                    'class' => 'grid grid-cols-1 md:grid-cols-6 gap-4 items-end',
            ],
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['class' => 'border border-gray-300 rounded-lg p-2'])->label('ID') ?>
    <?= $form->field($model, 'user_id')->textInput(['class' => 'border border-gray-300 rounded-lg p-2'])->label('User ID') ?>
    <?= $form->field($model, 'restaurant_id')->textInput(['class' => 'border border-gray-300 rounded-lg p-2'])->label('Restaurant ID') ?>
    <?= $form->field($model, 'courier_id')->textInput(['class' => 'border border-gray-300 rounded-lg p-2'])->label('Courier ID') ?>
    <?= $form->field($model, 'total')->textInput(['class' => 'border border-gray-300 rounded-lg p-2'])->label('Total') ?>

    <div class="flex gap-2">
        <?= Html::submitButton('Search', ['class' => 'bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition']) ?>
        <?= Html::resetButton('Reset', ['class' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow transition']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
