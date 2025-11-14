<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $product frontend\models\ProductsModel */
    /* @var $productTag frontend\models\ProductTagsModel */
    /* @var $productDetails frontend\models\ProductDetailModel */
    /* @var $restaurantList array */
    /* @var $categories array */
    /* @var $tags array */
    /** @var array $selectedTags */
    /** @var string $title */
$this->title = 'product qoshish';
?>

<div class="min-h-[80vh] py-10 flex items-center justify-center dark:bg-[#191918]">
    <div class="w-full max-w-2xl bg-white dark:bg-[#1f1f1f] shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white text-center">
            <?= Html::encode($title) ?>
        </h1>

        <?php $form = ActiveForm::begin([
                'id' => 'add-product-form',
                'options' => ['class' => 'space-y-6', 'enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                        'errorOptions' => ['class' => 'text-red-500 text-sm mt-1'],
                ],
        ]); ?>

        <!-- ОСНОВНАЯ ИНФОРМАЦИЯ О ПРОДУКТЕ -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b dark:border-gray-700 pb-2">
                Asosiy ma'lumotlar
            </h2>

            <?= $form->field($product, 'restaurant_id')->dropDownList(
                    $restaurantList,
                    [
                            'prompt' => 'Restoranni tanlang',
                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-yellow-400 
                        dark:bg-[#2c2c2c] dark:text-white'
                    ]
            )->label('Restoran', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>

            <?= $form->field($product, 'name', [
                    'inputOptions' => [
                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-yellow-400 
                        dark:bg-[#2c2c2c] dark:text-white',
                            'placeholder' => 'Mahsulot nomi',
                    ],
            ])->label('Mahsulot nomi', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>

            <?= $form->field($product, 'category_id')->dropDownList(
                    $categories,
                    [
                            'prompt' => 'Kategoriyani tanlang',
                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-yellow-400 
                        dark:bg-[#2c2c2c] dark:text-white'
                    ]
            )->label('Kategoriya', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>

            <?= $form->field($product, 'price', [
                    'inputOptions' => [
                            'type' => 'number',
                            'step' => '0.01',
                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-yellow-400 
                        dark:bg-[#2c2c2c] dark:text-white',
                            'placeholder' => 'Narx (so\'m)',
                    ],
            ])->label('Narx', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>

            <?= $form->field($product, 'status')->dropDownList([
                    'active' => 'Faol',
                    'inactive' => 'Nofaol',
            ], [
                    'prompt' => 'Holatini tanlang',
                    'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                    focus:outline-none focus:ring-2 focus:ring-yellow-400 
                    dark:bg-[#2c2c2c] dark:text-white cursor-pointer',
            ])->label('Holat', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>

            <!-- Rasm yuklash -->
            <div class="space-y-2">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Rasm yuklash</label>

                <div id="upload-area"
                     class="relative flex flex-col items-center justify-center border-2 border-dashed
                     border-gray-300 dark:border-gray-600 rounded-lg p-6 cursor-pointer
                     hover:border-yellow-400 transition duration-300 group">
                    <i class="bx bxs-cloud-upload text-4xl text-gray-400 group-hover:text-yellow-400"></i>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">
                        Rasmni tanlang yoki bu yerga tortib tashlang
                    </p>

                    <?= $form->field($product, 'image', [
                            'template' => '{input}{error}',
                    ])->fileInput([
                            'id' => 'image-input',
                            'class' => 'absolute inset-0 opacity-0 cursor-pointer',
                            'accept' => 'image/*',
                    ])->label(false) ?>
                </div>

                <!-- Preview -->
                <div id="image-preview" class="hidden mt-3">
                    <img src="" alt="Image Preview"
                         class="w-full h-48 object-cover rounded-lg border dark:border-gray-700 shadow-sm" />
                </div>
            </div>
        </div>

        <!-- TAGLAR -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b dark:border-gray-700 pb-2">
                Teglar
            </h2>

            <div class="space-y-3">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-2">Teglarni tanlang</label>

                <!-- Поиск тегов -->
                <div class="relative">
                    <input type="text" id="tag-search"
                           placeholder="Teg qidirish..."
                           class="w-full px-4 py-2 pl-10 rounded-md border border-gray-300 dark:border-gray-700
                        focus:outline-none focus:ring-2 focus:ring-yellow-400
                        dark:bg-[#2c2c2c] dark:text-white">
                    <i class="bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Выбранные теги -->
                <div id="selected-tags" class="flex flex-wrap gap-2 min-h-[40px] p-3 rounded-md border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-[#2c2c2c]">
                    <span class="text-gray-400 dark:text-gray-500 text-sm" id="no-tags-placeholder">Teglar tanlanmagan</span>
                </div>

                <!-- Список тегов с прокруткой -->
                <div id="tags-container" class="hidden max-h-64 overflow-y-auto border border-gray-300 dark:border-gray-700 rounded-md p-2 space-y-1">
                    <?php foreach ($tags as $tagId => $tagName): ?>
                        <label class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-[#2c2c2c] cursor-pointer transition tag-item"
                               data-tag-name="<?= strtolower(Html::encode($tagName)) ?>">
                            <input type="checkbox" name="tags[]" value="<?= $tagId ?>"
                                   class="tag-checkbox form-checkbox h-4 w-4 text-yellow-400 rounded focus:ring-yellow-400
                                dark:bg-[#2c2c2c] dark:border-gray-600"
                                   data-tag-id="<?= $tagId ?>"
                                   data-tag-text="<?= Html::encode($tagName) ?>">
                            <span class="text-gray-700 dark:text-gray-200 text-sm"><?= Html::encode($tagName) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Счетчик -->
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Tanlangan: <span id="selected-count" class="font-semibold text-yellow-500">0</span>
                </div>
            </div>
        </div>

        <!-- MAHSULOT TAFSILOTLARI -->
        <?php if ($productDetails->hasAttribute('description') ||
                $productDetails->hasAttribute('ingredients') ||
                $productDetails->hasAttribute('calories') ||
                $productDetails->hasAttribute('weight')): ?>
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b dark:border-gray-700 pb-2">
                    Mahsulot tafsilotlari
                </h2>

                <?php if ($productDetails->hasAttribute('description')): ?>
                    <?= $form->field($productDetails, 'description', [
                            'inputOptions' => [
                                    'rows' => 4,
                                    'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                            focus:outline-none focus:ring-2 focus:ring-yellow-400 
                            dark:bg-[#2c2c2c] dark:text-white resize-none',
                                    'placeholder' => 'Mahsulot haqida batafsil ma\'lumot...',
                            ],
                    ])->textarea()->label('Tavsif', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>
                <?php endif; ?>

                <?php if ($productDetails->hasAttribute('ingredients')): ?>
                    <?= $form->field($productDetails, 'ingredients', [
                            'inputOptions' => [
                                    'rows' => 3,
                                    'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                            focus:outline-none focus:ring-2 focus:ring-yellow-400 
                            dark:bg-[#2c2c2c] dark:text-white resize-none',
                                    'placeholder' => 'Tarkibi: un, tuz, suv...',
                            ],
                    ])->textarea()->label('Tarkibi', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>
                <?php endif; ?>

                <?php if ($productDetails->hasAttribute('calories') || $productDetails->hasAttribute('weight')): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if ($productDetails->hasAttribute('calories')): ?>
                            <?= $form->field($productDetails, 'calories', [
                                    'inputOptions' => [
                                            'type' => 'number',
                                            'step' => '1',
                                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                                    focus:outline-none focus:ring-2 focus:ring-yellow-400 
                                    dark:bg-[#2c2c2c] dark:text-white',
                                            'placeholder' => 'Kaloriya',
                                    ],
                            ])->label('Kaloriya (kcal)', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>
                        <?php endif; ?>

                        <?php if ($productDetails->hasAttribute('weight')): ?>
                            <?= $form->field($productDetails, 'weight', [
                                    'inputOptions' => [
                                            'type' => 'number',
                                            'step' => '0.01',
                                            'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                                    focus:outline-none focus:ring-2 focus:ring-yellow-400 
                                    dark:bg-[#2c2c2c] dark:text-white',
                                            'placeholder' => 'Og\'irligi',
                                    ],
                            ])->label('Og\'irligi (g)', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>


                <?php if ($productDetails->hasAttribute('preparation_time')): ?>
                    <?= $form->field($productDetails, 'preparation_time', [
                            'inputOptions' => [
                                    'type' => 'number',
                                    'step' => '1',
                                    'class' => 'w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 
                focus:outline-none focus:ring-2 focus:ring-yellow-400 
                dark:bg-[#2c2c2c] dark:text-white',
                                    'placeholder' => 'Tayyorlash vaqti (daqiqa)',
                            ],
                    ])->label('Tayyorlash vaqti (daqiqa)', ['class' => 'block text-gray-700 dark:text-gray-200 font-medium mb-2']) ?>
                <?php endif; ?>


            </div>
        <?php endif; ?>

        <div class="pt-4">
            <?= Html::submitButton('Saqlash', [
                    'class' => 'bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 
                    text-gray-900 dark:text-black font-semibold py-3 px-6 rounded-md w-full 
                    transition duration-200 shadow-md hover:shadow-lg',
                    'name' => 'add-product-button'
            ]) ?>
        </div>
    <?php


        $selectedTagsJson = json_encode($selectedTags);

                    $this->registerJs(<<<JS
            // Rasm preview
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
            
            // Drag & Drop
            const uploadArea = document.getElementById('upload-area');
            const imageInput = document.getElementById('image-input');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight(e) {
                uploadArea.classList.add('border-yellow-400', 'bg-yellow-50', 'dark:bg-yellow-900/10');
            }
            
            function unhighlight(e) {
                uploadArea.classList.remove('border-yellow-400', 'bg-yellow-50', 'dark:bg-yellow-900/10');
            }
            
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                imageInput.files = files;
                
                const event = new Event('change', { bubbles: true });
                imageInput.dispatchEvent(event);
            }
            
            // === ТЕГИ: Поиск и управление ===
            const tagSearch = document.getElementById('tag-search');
            const tagsContainer = document.getElementById('tags-container');
            const tagItems = document.querySelectorAll('.tag-item');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const selectedCountSpan = document.getElementById('selected-count');
            const noTagsPlaceholder = document.getElementById('no-tags-placeholder');
            const tagCheckboxes = document.querySelectorAll('.tag-checkbox');
            
            // ВАЖНО: Устанавливаем выбранные теги из PHP
            const selectedTagIds = $selectedTagsJson;
            console.log('Selected tags from PHP:', selectedTagIds);
            
            // Отмечаем чекбоксы для выбранных тегов
            tagCheckboxes.forEach(checkbox => {
                const tagId = parseInt(checkbox.getAttribute('data-tag-id'));
                if (selectedTagIds.includes(tagId)) {
                    checkbox.checked = true;
                    console.log('Checked tag:', tagId);
                }
            });
            
            // Показать список при фокусе на поле поиска
            tagSearch.addEventListener('focus', function() {
                tagsContainer.classList.remove('hidden');
            });
            
            // Поиск тегов
            tagSearch.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleCount = 0;
                
                if (searchTerm || tagsContainer.classList.contains('hidden')) {
                    tagsContainer.classList.remove('hidden');
                }
                
                tagItems.forEach(item => {
                    const tagName = item.getAttribute('data-tag-name');
                    if (tagName.includes(searchTerm)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                if (visibleCount === 0 && searchTerm) {
                    if (!document.getElementById('no-results-msg')) {
                        const msg = document.createElement('div');
                        msg.id = 'no-results-msg';
                        msg.className = 'text-center text-gray-500 dark:text-gray-400 py-4';
                        msg.textContent = 'Teglar topilmadi';
                        tagsContainer.appendChild(msg);
                    }
                } else {
                    const noResultsMsg = document.getElementById('no-results-msg');
                    if (noResultsMsg) noResultsMsg.remove();
                }
            });
            
            // Скрыть список при клике вне области
            document.addEventListener('click', function(e) {
                if (!tagSearch.contains(e.target) && !tagsContainer.contains(e.target)) {
                    if (!tagSearch.value.trim()) {
                        tagsContainer.classList.add('hidden');
                    }
                }
            });
            
            // Обновление отображения выбранных тегов
            function updateSelectedTags() {
                const selected = Array.from(tagCheckboxes).filter(cb => cb.checked);
                selectedCountSpan.textContent = selected.length;
                
                selectedTagsContainer.innerHTML = '';
                
                if (selected.length === 0) {
                    const placeholder = document.createElement('span');
                    placeholder.className = 'text-gray-400 dark:text-gray-500 text-sm';
                    placeholder.id = 'no-tags-placeholder';
                    placeholder.textContent = 'Teglar tanlanmagan';
                    selectedTagsContainer.appendChild(placeholder);
                } else {
                    selected.forEach(checkbox => {
                        const tagText = checkbox.getAttribute('data-tag-text');
                        const tagId = checkbox.getAttribute('data-tag-id');
                        
                        const badge = document.createElement('span');
                        badge.className = 'inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm bg-yellow-400 text-gray-900 dark:bg-yellow-500';
                        badge.innerHTML = tagText + ' <button type="button" class="ml-1 hover:text-red-600 text-lg font-bold" data-tag-id="' + tagId + '">×</button>';
                        
                        badge.querySelector('button').addEventListener('click', function() {
                            checkbox.checked = false;
                            updateSelectedTags();
                        });
                        
                        selectedTagsContainer.appendChild(badge);
                    });
                }
            }
            
            // Слушаем изменения чекбоксов
            tagCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTags);
            });
            
            // ВАЖНО: Инициализация при загрузке с уже выбранными тегами
            updateSelectedTags();
            
            JS, \yii\web\View::POS_READY);
    ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>