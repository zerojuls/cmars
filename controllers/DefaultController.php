<?php

namespace mtrofimenko\cmars\controllers;

use yii\web\Controller;

class DefaultController extends Controller {

    public function actionIndex() {
        return $this->render('welcome');
    }

}
