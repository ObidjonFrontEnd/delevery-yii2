<?php
/** @var \frontend\models\UserModel $restarans */
/** @var \frontend\models\CategoriesModel $categories */
/** @var \frontend\models\CategoriesModel $categories2 */
use yii\widgets\LinkPager;
/** @var yii\data\Sort $sort */
/** @var object $pagination */
use yii\helpers\Url;
/** @var int $category_id */
$this->title = 'Restaranlar';
?>
<section class=" ">

   <div class="mt-[20px] mb-[20px] px-[20px] dark:text-white py-[20px] bg-white rounded-lg gap-[5px] dark:bg-[#1f1f1f] flex items-center justify-between">

      <div>
          <a href="<?=(Url::to(['']))?>" class="px-4 py-2 rounded-full bg-yellow-500 text-gray-900 font-semibold whitespace-nowrap">
              Hammasi
          </a>

          <?php foreach ($categories as $item): ?>
              <a href="<?=(Url::to(['restaran/index', 'category'=>$item->id ]))?>" class=" <?=( $category_id == $item->id ) ? 'bg-gray-700 text-white' : '' ?>
                        px-4 py-2 rounded-full hover:bg-gray-700 duration-300 hover:text-white  font-medium whitespace-nowrap
                    ">
                  <?=($item->name)?? ""?>
              </a>
          <?php endforeach;?>

          <div class="dropdown dropdown-end">
              <div tabindex="0" role="button" class="px-4 py-2 rounded-full hover:bg-gray-700 duration-300 gap-[5px]  flex items-center justify-center hover:text-white  font-medium whitespace-nowrap"> Yana <i class='bxr  bx-chevron-left rotate-[-90deg] text-[20px]'  ></i></div>
              <ul tabindex="-1" class="dropdown-content menu dark:bg-[#1f1f1f] bg-white rounded-box z-1 w-52 p-2 shadow-sm">
                  <?php foreach ($categories2 as $item): ?>
                    <li><a href="<?=(Url::to(['restaran/index', 'category'=>$item->id ]))?>"
                           class=" font-medium <?=( $category_id == $item->id ) ? 'bg-gray-700 text-white' : '' ?>">
                            <?=($item->name)?? "" ?>
                        </a>
                    </li>
                  <?php endforeach;?>
              </ul>
          </div>
      </div>



       <div class="dropdown dropdown-end">
           <button tabindex="0" role="button" class="ml-auto px-3 py-2 rounded-full bg-gray-700 text-white  flex items-center gap-1 hover:bg-gray-600">
               <i class='bxr  bx-slider-vertical rotate-90'  ></i>
               Saralash
           </button>
           <ul tabindex="-1" class="dropdown-content menu text-white dark:bg-[#1f1f1f] bg-gray-700 rounded-box z-1 w-52 p-2 shadow-sm">

                   <?= $sort->link('rate', [
                           'label' => 'Yuqori baho',
                           'class' => 'px-4 py-2  text-white rounded-lg  transition'
                   ]) ?></li>
               <li><a>Tez yetkazib berish</a></li>
           </ul>
       </div>
   </div>




    <?php if(isset($restarans) && !empty($restarans) ?? !is_null($restarans)) :?>
        <div class="grid lg:grid-cols-4 grid-cols-1 lg:grid-rows-2 gap-[20px] w-full">
            <?php foreach ($restarans as $items): ?>

                <a href="<?= \yii\helpers\Url::to(['restaran/view', 'id' => $items->id]) ?>"
                   class="card bg-base-100 dark:bg-[#2c2c2c] shadow-sm block overflow-hidden">

                    <figure class="relative w-full h-[200px] overflow-hidden bg-gray-200 dark:bg-gray-700">
                        <?php if (!empty($items->image)): ?>
                            <img src="<?= Yii::getAlias('@web') ?>/image/<?= $items->image ?>"
                                 alt="<?= $items->title ?? '' ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <!-- Placeholder для отсутствующего изображения -->
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                                <i class="bx bx-restaurant text-6xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                        <?php endif; ?>
                    </figure>

                    <div class="w-full justify-between gap-[10px] flex py-[10px] px-[20px] min-h-[70px]">
                        <h2 class="card-title text-[20px] font-semibold line-clamp-2 flex-1">
                            <?= $items->title ?? 'Без названия' ?>
                        </h2>

                        <div class="text-[20px] flex-shrink-0">
                            <?php
                            $rate = $items->rate ?? 0;
                            $fullStars = floor($rate);
                            $halfStar = ($rate - $fullStars) >= 0.5;

                            for ($i = 0; $i < $fullStars; $i++) {
                                echo "<i class='bx bxs-star text-yellow-400'></i>";
                            }

                            if ($halfStar) {
                                echo "<i class='bx bxs-star-half text-yellow-400'></i>";
                            }

                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo "<i class='bx bx-star text-yellow-400'></i>";
                            }
                            ?>
                        </div>
                    </div>
                </a>

            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="else min-h-[80vh] flex flex-col items-center justify-center py-20 text-center text-gray-500 dark:text-gray-400 gap-4">
            <p>Restaran mavjud emas.</p>

        </div>
    <?php endif; ?>


    <div class="mt-[20px] flex justify-end">
        <?php


        echo LinkPager::widget([
                    "pagination" => $pagination,
                    'options'=>['class'=>'flex items-center gap-[10px]'],
                    "linkOptions"=>["class" => "border-[1px] rounded-lg   h-[40px] w-[40px] border-gray-400 flex items-center justify-center"],
                    'activePageCssClass' => ['class'=>'bg-yellow-400 rounded-lg'],
                    'disabledPageCssClass' => ['class'=>'hidden'],
            ]);

        ?>
    </div>



</section>