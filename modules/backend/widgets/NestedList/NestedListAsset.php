<?php

namespace mtrofimenko\cmars\modules\backend\widgets\NestedList;

use yii\web\AssetBundle;

class NestedListAsset extends AssetBundle {

    public $js = [
        'assets/jquery.nestable.js'
    ];
    public $css = [
        'assets/nested.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init() {
        $this->sourcePath = dirname(__DIR__ . '/assets');
    }

}
