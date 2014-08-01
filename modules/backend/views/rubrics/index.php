<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;

$this->title = Yii::t('rubrics', 'Rubrics');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => false,
            'showFooter' => false,
            'export' => false,
            'panel' => [
                'heading' => '<h3 class="panel-title">' . Icon::show('files-o') . Yii::t('rubrics', 'Rubrics') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . Yii::t('rubrics', 'Create'), ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('rubrics', 'Reset'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'width' => '25%',
                ],
                'title',
                [
                    'header' => Yii::t('rubrics', 'Actions'),
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                   
                    'viewOptions' => ['title' => Yii::t('rubrics', 'Details')],
                    'updateOptions' => ['title' => Yii::t('rubrics', 'Edit page')],
                    'deleteOptions' => ['title' => Yii::t('rubrics', 'Delete action')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>