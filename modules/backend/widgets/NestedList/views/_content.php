<?php

use yii\helpers\Html;
?>

<?php
echo $item['label'];
?>

<?php echo Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete', 'id' => $options['data-id']], ['class' => 'pull-right btn btn-xs btn-danger', 'data-confirm' => 'Are you sure', 'data-method' => 'post']); ?>&nbsp;
<?php echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $options['data-id']], ['class' => 'pull-right btn btn-xs btn-info colorbox']); ?>