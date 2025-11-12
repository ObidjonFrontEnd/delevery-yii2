<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var \frontend\controllers\ProfileController $model */
$this->title = 'Profilni tahrirlash';
?>

<div class="max-w-2xl mx-auto mt-10 p-6 bg-white dark:bg-[#1f1f1f] rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'options' => ['class' => 'space-y-6'],
            'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1'],
                    'inputOptions' => [
                            'class' => 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:outline-none dark:bg-[#2c2c2c] dark:text-white',
                    ],
                    'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
            ],
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>
    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
    <?= $form->field($model, 'phone_number')->textInput(['type' => 'tel']) ?>
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
                 class="w-[200px] h-[200px]  object-cover rounded-lg border dark:border-gray-700 shadow-sm" />
        </div>
    </div>

    <?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>

    <div class="flex justify-end">
        <?= Html::submitButton('Saqlash', ['class' => 'bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-6 py-2 rounded-lg transition duration-200']) ?>
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
