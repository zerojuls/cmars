<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\detail\DetailView;

$this->title = Yii::t('rubrics', 'Rubric \'{name}\'', ['name' => $model->name]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('rubrics', 'Rubrics'),
        'url' => ['rubrics/index']
    ],
    $this->title
];
?>

<div class="row">
    <div class="col-lg-6">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'enableEditMode' => false,
            'panel' => [
                'heading' => Icon::show('files-o') . Yii::t('rubrics', 'Rubrics') .
                Html::a(Icon::show('files-o') . Yii::t('rubrics', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                'type' => DetailView::TYPE_DEFAULT,
            ],
            'attributes' => array_merge([
                'id',
                'name',
                    ], $atributes),
        ]);
        ?>
    </div>
</div>