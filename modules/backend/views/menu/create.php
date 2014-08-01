<?php
$this->title = 'Create new menu';
$this->params['breadcrumbs'] = [
    [
        'label' => 'Menu editor',
        'url' => ['index']
    ],
    $this->title
];
?>

<div class="row">
    <div class="col-md-4">
        <?php echo $this->render('_form', ['model' => $model]); ?>
    </div>
</div>
