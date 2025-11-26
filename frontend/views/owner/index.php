<?php
/** @var \frontend\models\UserModel $restarans */
/** @var \frontend\controllers\RestaranController $pagination */
$this->title = 'Restaranlarim';
?>
<section class=" ">

    <?php if(isset($restarans) && !empty($restarans) ?? !is_null($restarans)) :?>
        <div class="grid lg:grid-cols-4 grid-cols-1 lg:grid-rows-2 gap-[20px] w-full">
            <?php foreach ($restarans as $items): ?>

                <div class="card bg-base-100 dark:bg-[#2c2c2c] shadow-sm block relative">
                    <a href="<?= \yii\helpers\Url::to(['restaran/view', 'id' => $items->id]) ?>" class="block">
                        <figure class="relative">
                            <img src="<?= Yii::getAlias('@web') ?>/image/<?= $items->image ?? '' ?>" alt="Default">
                        </figure>

                        <div class="w-full justify-between gap-[10px] flex py-[10px] px-[20px]">
                            <h2 class="card-title text-[20px] font-semibold"><?= $items->title ?? '' ?></h2>

                            <div class="text-[20px]">
                                <?php
                                $fullStars = floor($items->rate ?? 0);
                                $halfStar = (($items->rate ?? 0) - $fullStars) >= 0.5;
                                for ($i = 0; $i < $fullStars; $i++) echo "<i class='bxr bxs-star text-yellow-400'></i>";
                                if ($halfStar) echo "<i class='bxr bxs-star-half text-yellow-400'></i>";
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                for ($i = 0; $i < $emptyStars; $i++) echo "<i class='bxr bx-star text-yellow-400'></i>";
                                ?>
                            </div>
                        </div>
                    </a>


                    <div class="absolute top-3 right-3 flex flex-col gap-2 z-10">

                        <?= \yii\helpers\Html::beginForm(['owner/delete', 'id' => $items->id], 'post', ['class' => 'inline']) ?>
                        <?= \yii\helpers\Html::submitButton(
                                    '<i class="bx bxs-trash"></i>',
                                    [
                                            'class' => 'text-red-500 text-[20px] hover:scale-110 transition-transform bg-white dark:bg-[#2c2c2c] rounded-full h-[38px] w-[38px] flex items-center justify-center shadow-md',
                                            'title' => "O'chirish",
                                            'data-confirm' => "Haqiqatan ham o'chirmoqchimisiz?",
                                            'onclick' => 'event.stopPropagation();'
                                    ]
                            ) ?>
                        <?= \yii\helpers\Html::endForm() ?>


                        <?= \yii\helpers\Html::a(
                                '<i class="bx bxs-edit"></i>',
                                ['owner/edit', 'id' => $items->id],
                                [
                                        'class' => 'text-yellow-400 text-[20px] hover:scale-110 transition-transform bg-white dark:bg-[#2c2c2c] rounded-full h-[38px] w-[38px] flex items-center justify-center shadow-md',
                                        'title' => 'Tahrirlash',
                                        'onclick' => 'event.stopPropagation();'
                                ]
                        ) ?>
                    </div>
                </div>

            <?php endforeach;?>
        </div>
    <?php else: ?>
        <div class="else min-h-[80vh] flex flex-col items-center justify-center py-20 text-center text-gray-500 dark:text-gray-400 gap-4">
            <p>Sizda restoronlar mavjud emas.</p>
        <?= \yii\helpers\Html::a(
                "Restoran qo'shish",
                    ['owner/add'],
                    [
                        'class' => 'bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-black font-semibold py-2 px-4 rounded-md transition duration-200'
                    ]
                ) ?>
        </div>
    <?php endif; ?>

    <div class="fab">
        <!-- a focusable div with tabindex is necessary to work on all browsers. role="button" is necessary for accessibility -->
        <div tabindex="0" role="button" class="btn btn-lg btn-circle btn-primary"><i class='bxr  bx-plus'  ></i> </i></div>
        <div class="fab-close">
            Close <span class="btn btn-circle btn-lg btn-error">✕</span>
        </div>



            <?= \yii\helpers\Html::a(
                    "Restaran Qo'shish",
                    ['owner/add'],
                    [
                            'class' => 'font-bold bg-green-500  rounded-lg transition duration-200 px-[20px] py-[10px]'
                    ]
            ) ?>
        <?= \yii\helpers\Html::a(
                "Prodcut Qo'shish",
                ['add-product'],
                [
                        'class' => 'font-bold bg-yellow-400 rounded-lg transition duration-200 px-[20px] py-[10px]'
                ]
        ) ?>

    </div>



    <div class="mt-[20px] flex justify-end">
        <?php
        echo \yii\widgets\LinkPager::widget([
                "pagination" => $pagination,
                'options'=>['class'=>'flex items-center gap-[10px]'],
                "linkOptions"=>["class" => "border-[1px] rounded-lg   h-[40px] w-[40px] border-gray-400 flex items-center justify-center"],
                'activePageCssClass' => ['class'=>'bg-yellow-400 rounded-lg'],
                'disabledPageCssClass' => ['class'=>'hidden'],
        ]);
        ?>
    </div>
</section>