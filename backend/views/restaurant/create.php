
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rate')->textInput() ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

<?php if ($model->image): ?>
    <div class="form-group">
        <label>Joriy rasm:</label><br>
        <img src="<?= $model->getImageUrl() ?>" alt="" style="max-width: 200px;">
    </div>
<?php endif; ?>

<div class="form-group">
    <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>