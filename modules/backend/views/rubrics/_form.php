<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
?>

<div class="row">
    <div class="col-lg-6">


        <?php $this->render('/includes/_lang_tabs', ['translates' => $translates]) ?>

        <div class="tab-content">
            <?php foreach ($translates as $key => $translate): ?>
                <div class="tab-pane <?= ($translate->language == Yii::$app->language) ? 'active' : ''; ?>" id="<?= $translate->language; ?>">
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => true,
                                'enableAjaxValidation' => false,
                                'validateOnChange' => false
                    ]);
                    echo $form->field($model, 'name');

                    echo $form->field($translate, 'language')->hiddenInput()->label('', ['style' => 'display:none']);
                    echo $form->field($translate, 'rubric_id')->hiddenInput(['value' => $model->id])->label('', ['style' => 'display:none']);
                    echo $form->field($translate, 'title');
                    echo $form->field($translate, 'meta_title');
                    echo $form->field($translate, 'meta_descriptions');
                    echo $form->field($translate, 'meta_keywords');

                    echo Html::submitButton(Yii::t('rubrics', 'Save'), [
                        'class' => 'btn btn-lg btn-success pull-right'
                    ]);
                    ActiveForm::end();
                    ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
