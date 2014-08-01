<?php

$this->title = Yii::t('pages', 'Create post');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('pages', 'Post'),
        'url' => ['index']
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'translates' => $translates,
    'postStatuses' => $postStatuses,
    'rubrics' => $rubrics
]);
?>