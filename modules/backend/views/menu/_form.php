<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'description')->textarea() ?>
<div class="form-group">
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
</div>
<?php ActiveForm::end(); ?>