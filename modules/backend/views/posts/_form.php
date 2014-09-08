<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\icons\Icon;
use yii\jui\DatePicker;
use common\extensions\fileapi\FileAPIAdvanced;
use tpoxa\cmars\models\Post;
use a3ch3r46\tinymce\TinyMCE;
?>

<div class="row">
    <div class="col-lg-12">

        <?php $this->render('/includes/_lang_tabs', ['translates' => $translates]) ?>


        <div class="tab-content">
            <?php foreach ($translates as $key => $translate): ?>
                <div class="tab-pane <?= ($translate->language == Yii::$app->language) ? 'active' : ''; ?>"
                     id="<?= $translate->language; ?>">
                         <?php
                         $form = ActiveForm::begin([
                                     'enableClientValidation' => true,
                                     'enableAjaxValidation' => true,
                                     'validateOnChange' => false
                         ]);

                         echo $form->field($model, 'author_id')->hiddenInput(['value' => Yii::$app->user->id])->label('', ['style' => 'display:none']);
                         echo $form->field($translate, 'language')->hiddenInput()->label('', ['style' => 'display:none']);
                         ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                            if ($this->context->module->enableRubrics) {
                                echo $form->field($model, 'rubric_id')->dropDownList($rubrics, ['prompt' => Yii::t('posts', 'Select Rubric')]);
                            }
                            echo $form->field($model, 'status')->dropDownList($postStatuses, ['prompt' => Yii::t('posts', 'Select Status')]);

                            echo $form->field($translate, 'title');
                            echo $form->field($model, 'alias');
                            ?>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-lg-12">
                            <?=
                            TinyMCE::widget(['model' => $translate,
                                'attribute' => 'full_text',
                                'id' => $translate->language,
                                'toggle' => ['active' => true]
                            ]);
                            ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">



                            <?=
                            $form->field($model, 'published_date')->widget(DatePicker::className(), [
                                'clientOptions' => [
                                    'dateFormat' => 'yy-mm-dd',
                                ],
                                'language' => 'en-US',
                                'options' => [
                                    'id' => "published_date_{$translate->language}",
                                    'class' => 'form-control',
                                    'style' => 'width: 100px'
                                ]
                            ])
                            ?>

                            <?php
                            echo $form->field($translate, 'meta_title');
                            echo $form->field($translate, 'meta_descriptions');
                            echo $form->field($translate, 'meta_keywords');

                            echo Html::submitButton(Yii::t('rubrics', 'Save'), [
                                'class' => 'btn btn-lg btn-success pull-right'
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                    ActiveForm::end();
                    ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
