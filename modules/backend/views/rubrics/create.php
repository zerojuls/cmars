<?php

$this->title = Yii::t('rubrics', 'Create rubric');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('rubrics', 'Rubrics'),
        'url' => ['rubrics/index']
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'translates' => $translates,
]);
?>