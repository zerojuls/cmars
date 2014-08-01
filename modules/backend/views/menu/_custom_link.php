<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>


<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>

<div class="row">
    <div class="col-md-10">
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'url') ?>
        <?php echo Html::activeHiddenInput($model, 'type', ['value' => 'custom']); ?>
    </div>
</div>
<div class="form-group text-right">
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
</div>
<?php ActiveForm::end(); ?>