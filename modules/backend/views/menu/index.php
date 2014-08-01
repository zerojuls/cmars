<?php
$this->title = $model->description2;

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use \yii\web\JsExpression;
use mtrofimenko\cmars\modules\backend\widgets\NestedList\NestedList;
use yii\bootstrap\Tabs;
use himiklab\colorbox\Colorbox;
?>



<div class="row">
    <div class="col-md-5">
        <?php $form = ActiveForm::begin(['id' => 'switch-form', 'type' => ActiveForm::TYPE_INLINE]); ?>
        <?= $form->field($switchForm, 'menu_id')->dropDownList($switchForm->getItems(), ['prompt' => 'Select menu to edit', 'onchange' => new JsExpression('this.form.submit();')]); ?>

        <?= Html::a('+', ['create'], ['class' => 'btn btn-success']); ?>

        <?php ActiveForm::end(); ?>
        <hr/>
        <?php //print_r($model->getItemsMenu());?>
        <?php echo NestedList::widget(['items' => $model->getItemsMenu()]); ?>
    </div>
    <div class="col-md-5 pull-right newmenutype" style="padding-top: 12px">
        <?php
        echo Tabs::widget([
            'items' => $this->context->getMenuSections($model),
        ]);
        ?>
    </div>
</div>

<?=
Colorbox::widget([
    'targets' => [
        '.colorbox' => [
            'maxWidth' => 800,
            'maxHeight' => 600,
            'width' => 800,
            'height' => 300,
        ],
    ]
])
?>

