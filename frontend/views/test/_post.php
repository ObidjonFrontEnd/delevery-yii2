<?php
/** @var object $model */
//echo \yii\widgets\DetailView::widget([
//    'model' => $model,
//]);
?>
<a href="<?= \yii\helpers\Url::to(['restarans/view', 'id' => $model->id]) ?>" class="card bg-base-100 dark:bg-[#2c2c2c] shadow-sm block">
    <figure class="relative">
        <img src="<?= Yii::getAlias('@web') ?>/image/<?= $model->image ?? '' ?>" alt="Default">
    </figure>

    <div class="w-full justify-between gap-[10px] flex py-[10px] px-[20px]">
        <h2 class="card-title text-[20px] font-semibold"><?= $model->title ?? '' ?></h2>

        <div class="text-[20px]">
            <?php
            $fullStars = floor($model->rate ?? 0);
            $halfStar = (($model->rate ?? 0) - $fullStars) >= 0.5;
            for ($i = 0; $i < $fullStars; $i++) echo "<i class='bxr bxs-star text-yellow-400'></i>";
            if ($halfStar) echo "<i class='bxr bxs-star-half text-yellow-400'></i>";
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            for ($i = 0; $i < $emptyStars; $i++) echo "<i class='bxr bx-star text-yellow-400'></i>";
            ?>
        </div>
    </div>
</a>

