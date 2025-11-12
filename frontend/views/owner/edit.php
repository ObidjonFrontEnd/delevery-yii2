<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RestauransModel */
/* @var $addresses frontend\controllers\OwnerController  */

$this->title = "Restoran tahrirlash";
?>

<div class="min-h-[80vh] py-[10px] flex items-center justify-center dark:bg-[#191918]">
    <div class="w-full max-w-md bg-white dark:bg-[#1f1f1f] shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">
            <?= Html::encode($this->title) ?>
        </h1>

        <?php $form = ActiveForm::begin([
                'id' => 'add-restaurant-form',
                'options' => ['class' => 'space-y-4', 'enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                        'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
                ],
        ]); ?>

        <?= $form->field($model, 'title', [
                'inputOptions' => [
                        'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-[#2c2c2c] dark:text-white',
                        'placeholder' => 'Restoran nomi',
                ],
        ])->label(false) ?>

        <?= $form->field($model, 'phone_number', [
                'inputOptions' => [
                        'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-[#2c2c2c] dark:text-white',
                        'placeholder' => 'Telefon raqam',
                ],
        ])->label(false) ?>

        <?= $form->field($model, 'address_id', [
                'template' => '{input}{error}', // убираем label
        ])->dropDownList(
                $addresses,
                [
                        'prompt' => 'Addressni tanlang',
                        'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                    focus:outline-none focus:ring-2 focus:ring-yellow-400 
                    dark:bg-[#2c2c2c] dark:text-gray-300  cursor-pointer',
                ]
        ); ?>




        <div class="space-y-2">
            <label class="block text-gray-700 dark:text-gray-200 font-medium">Rasm yuklash</label>

            <div id="upload-area"
                 class="relative flex flex-col items-center justify-center border-2 border-dashed
                border-gray-300 dark:border-gray-600 rounded-lg p-6 cursor-pointer
                hover:border-yellow-400 transition duration-300 group">
                <i class="bx bxs-cloud-upload text-4xl text-gray-400 group-hover:text-yellow-400"></i>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">
                    Rasmni tanlang yoki bu yerga tortib tashlang
                </p>

                <?= $form->field($model, 'image', [
                        'template' => '{input}{error}',
                ])->fileInput([
                        'id' => 'image-input',
                        'class' => 'absolute inset-0 opacity-0 cursor-pointer',
                        'accept' => 'image/*',
                ])->label(false) ?>
            </div>

            <!-- Предпросмотр -->
            <div id="image-preview" class="hidden mt-3">
                <img src="" alt="Image Preview"
                     class="w-full h-48 object-cover rounded-lg border dark:border-gray-700 shadow-sm" />
            </div>
        </div>


        <?= $form->field($model, 'description')->textarea([
                'rows' => 4,
                'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white resize-none',
                'placeholder' => 'Restoran tavsifi...',
        ])->label(false) ?>

        <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->session->get('user_id')])->label(false) ?>

        <div class="flex items-center justify-between">
            <?= Html::submitButton('Saqlash', [
                    'class' => 'bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-black font-semibold py-2 px-4 rounded-md w-full transition duration-200',
                    'name' => 'add-restaurant-button'
            ]) ?>
        </div>
        <?php
        $this->registerJs(<<<JS
            document.getElementById('image-input').addEventListener('change', function(event) {
                const preview = document.getElementById('image-preview');
                const img = preview.querySelector('img');
                const file = event.target.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                }
            });
            JS);
        ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
