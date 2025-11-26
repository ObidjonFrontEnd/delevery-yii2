<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var int $currentYear */
/** @var array $availableYears */
/** @var array $orders */
/** @var array $product_data */
/** @var float $total */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

$translations = [
        'sales' => Yii::t('app', 'Sales'),
        'percent' => Yii::t('app', 'Percent'),
        'totalSales' => Yii::t('app', 'Total Sales'),
        'average' => Yii::t('app', 'Average'),
        'bestCategory' => Yii::t('app', 'Best Category'),
        'pleaseFillFields' => Yii::t('app', 'Please fill all fields!'),
        'itemsSold'=>Yii::t('app', 'Items sold (pcs)'),
        'pcs'=>Yii::t('app', 'pcs'),
        'total'=>Yii::t('app', 'Total'),
        'quantity'=>Yii::t('app', 'Quantity (pcs)'),
        'language' => Yii::$app->language,
];

$this->registerJs("
    const translations = " . json_encode($translations) . ";
    const dbData = " . json_encode($orderDetails) . ";
    const monthlyData = " . \yii\helpers\Json::encode($orders) . ";
    const categoryViewUrl = '" . Url::toRoute(['category/view/__ID__']) . "';
    initChart(dbData);
", View::POS_END);

?>

<!-- Фильтр по годам -->
<div class="pb-5">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <label class="fs-5 fw-semibold mb-0"><?= Yii::t('app', 'Select Year') ?>:</label>
                    <select id="yearFilter" class="form-select form-select-solid w-auto">
                        <?php foreach ($availableYears as $yearOption): ?>
                            <option value="<?= $yearOption ?>" <?= $yearOption == $currentYear ? 'selected' : '' ?>>
                                <?= $yearOption ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="fs-6 text-muted"><?= Yii::t('app', 'Currently viewing') ?>: <strong><?= $currentYear ?></strong></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    $('#yearFilter').on('change', function() {
        const selectedYear = $(this).val();
        window.location.href = '" . Url::to(['index']) . "/year/' + selectedYear;
    });
", View::POS_READY);
?>

<div class="pb-5">
    <div class="container">
        <div class="chart-container">
            <div id="chart"></div>
            <div class="axis-labels">
                <span>0</span>
                <span id="label1">5K</span>
                <span id="label2">10K</span>
                <span id="label3">15K</span>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-value" id="totalValue">0</div>
                    <div class="stat-label"><?= Yii::t('app', 'Total Sales') ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="avgValue">0</div>
                    <div class="stat-label"><?= Yii::t('app', 'Average') ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="maxCategory">-</div>
                    <div class="stat-label"><?= Yii::t('app', 'Best Category') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tooltip" id="tooltip"></div>
</div>

<div class="px-9">
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <div class="card chart card-flush mb-10 overflow-hidden h-md-100">
            <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                <div class="px-9 mb-5">
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"><?= $total ?></span>
                        <span class="fs-4 fw-semibold text-gray-500 me-1"><?= Yii::t('app', 'UZS') ?></span>
                    </div>
                </div>
                <div id="widget-1" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
            </div>
        </div>
    </div>
</div>