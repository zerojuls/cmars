<?php if (sizeof($translates) > 1): ?>
    <ul class="nav nav-tabs">
        <?php foreach ($translates as $key => $translate): ?>
            <li class="<?= ($translate->language == Yii::$app->language) ? 'active' : ''; ?>">
                <a href="#<?= $translate->language; ?>"
                   data-toggle="tab"> <?= Yii::$app->params['languages'][$translate->language]; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>