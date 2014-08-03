<?php

namespace tpoxa\cmars\modules\backend\controllers;
use tpoxa\cmars\modules\backend\components\Controller;


class DefaultController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}
