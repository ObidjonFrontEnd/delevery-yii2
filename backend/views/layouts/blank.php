<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<?php $this->beginBody() ?>

    <main role="main">

        <?= $content ?>

    </main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
