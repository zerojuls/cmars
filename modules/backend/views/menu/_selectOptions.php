<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>


<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>

<div class="row">
    <div class="col-md-10">
         <?= $form->field($model, 'type')->dropDownList($items, ['class'=>'form-control']) ?>
        
        <?= $form->field($model, 'title') ?>
    </div>
</div>
<div class="form-group text-right">
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
</div>
<?php ActiveForm::end(); ?>

