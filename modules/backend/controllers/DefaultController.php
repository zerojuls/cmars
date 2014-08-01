<?php

namespace mtrofimenko\cmars\modules\backend\controllers;
use mtrofimenko\cmars\modules\backend\components\Controller;


class DefaultController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}
