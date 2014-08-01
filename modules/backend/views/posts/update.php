<?php

$this->title = Yii::t('pages', 'Update post #{id}', [
    'id' => $model->id
]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('pages', 'Posts'),
        'url' => ['index']
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'translates' => $translates,
    'sections' => $sections,
    'postStatuses' => $postStatuses,
    'rubrics' => $rubrics
]);

?>