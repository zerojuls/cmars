<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use common\models\User;
use tpoxa\cmars\models\Post;

$this->title = Yii::t('pages', 'Posts');
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
                'heading' => '<h3 class="panel-title">' . Icon::show('lock') . Yii::t('pages', 'Pages') . '</h3>',
                'type' => 'default',
                'before' => Html::a(Icon::show('plus') . Yii::t('pages', 'Create'), ['create'], ['class' => 'btn btn-success']),
                'after' => Html::a(Icon::show('repeat') . Yii::t('pages', 'Reset'), ['index'], ['class' => 'btn btn-info'])
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'title',
                'alias',
                [
                    'attribute' => 'author_id',
                    'vAlign' => 'middle',
                    'value' => function ($model) {
                $user = User::find()
                        ->select(['username'])
                        ->where(['id' => $model->author_id])
                        ->one();
                return $user->username;
            },
                    'filter' => Html::activeDropDownList($searchModel, 'author_id', $users, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Users')])
                ],
                [
                    'attribute' => 'status',
                    'vAlign' => 'middle',
                    'value' => function ($model) {
                $postStatuses = Post::getStatusArray();
                return $postStatuses[$model->status];
            },
                    'filter' => Html::activeDropDownList($searchModel, 'status', $postStatuses, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Status')])
                ],
                'views',
                [
                    'header' => Yii::t('pages', 'Actions'),
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'viewOptions' => ['title' => Yii::t('pages', 'Details')],
                    'updateOptions' => ['title' => Yii::t('pages', 'Edit page')],
                    'deleteOptions' => ['title' => Yii::t('pages', 'Delete action')],
                ],
                ['class' => 'kartik\grid\CheckboxColumn']
            ],
        ]);
        ?>
    </div>
</div>