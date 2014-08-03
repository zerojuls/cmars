<?php

namespace tpoxa\cmars\modules\backend;

use tpoxa\cmars\CMARS;

class CMARSBackend extends CMARS {

    public $controllerNamespace = 'tpoxa\cmars\modules\backend\controllers';

    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public function getMenu() {

        return [
            ['label' => 'Navigation', 'url' => ['/cms/admin/menu/index']],
            ['label' => 'Posts', 'url' => ['/cms/admin/posts/index'], 'visible' => $this->enablePosts],
            ['label' => 'Rubrics', 'url' => ['/cms/admin/rubrics/index'], 'visible' => $this->enableRubrics]
        ];
    }

}
