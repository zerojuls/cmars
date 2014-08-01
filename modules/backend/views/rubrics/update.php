<?php

$this->title = Yii::t('rubrics', 'Rubric \'{name}\'', ['name' => $model->name]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('rubrics', 'Rubrics'),
        'url' => 'rubrics'
    ],
    $this->title
];

echo $this->render('_form', [
    'model' => $model,
    'translates' => $translates,
    'sections' => $sections
]);

?>