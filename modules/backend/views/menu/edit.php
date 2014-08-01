<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php
$form = ActiveForm::begin([
        ]);
?>

<div class="form">
    <?php
    echo $form->field($model, 'title');

    if ($model->type == 'custom'):
        echo $form->field($model, 'url');
    endif;

    echo Html::submitButton(Yii::t('rubrics', 'Save'), [
        'class' => 'btn btn-lg btn-success pull-right'
    ]);
    ?>

</div>
<?php
ActiveForm::end();
?>