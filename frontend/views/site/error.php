<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-6">
    <div class="bg-white dark:bg-[#1f1f1f] shadow-lg dark:shadow-[inset_2px_2px_4px_#141414,inset_-2px_-2px_4px_#1f1f1f] rounded-2xl p-10 max-w-lg w-full">
        <h1 class="text-4xl font-bold text-red-600 dark:text-red-400 mb-4">
            <?= Html::encode($this->title) ?>
        </h1>

        <p class="text-gray-700 dark:text-gray-300 text-lg mb-6">
            <?= nl2br(Html::encode($message)) ?>
        </p>

        <p class="text-gray-500 dark:text-gray-400 mb-8">
            So‘rovingizni qayta ishlashda xatolik yuz berdi.<br>
            Shaklni keyinroq tahrirlang yoki qo‘llab-quvvatlash xizmatiga murojaat qiling.
        </p>

        <div class="flex justify-center gap-4">
            <a href="/"
               class="px-5 py-2 bg-[#FCE000] text-black font-medium rounded-lg hover:scale-105 transition-transform">
                Restaranlarga qaytish
            </a>
            <button onclick="location.reload()"
                    class="px-5 py-2 border border-gray-400 dark:border-gray-500 dark:text-white rounded-lg hover:scale-105 transition-transform">
                Qayta urinib ko'ring
            </button>
        </div>
    </div>


</div>
