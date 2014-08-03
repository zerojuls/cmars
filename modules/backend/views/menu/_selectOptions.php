<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>


<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>

<div class="row">
    <div class="col-md-10">
        <?= $form->field($model, 'type')->dropDownList($items, [ 'id' => false, 'class' => 'chooseLink form-control']) ?>
        <?= $form->field($model, 'title')->textInput(['id' => false, 'class' => 'titleLink form-control']) ?>
    </div>
</div>
<div class="form-group text-right">
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php 

$this->registerJs('
        $(".chooseLink").change(function(){
            var text = $(this).find("option:selected").text();
            var container = $(this).parents("form").first();
            
            $(container).find(".titleLink").val(text);
       });
    ');

