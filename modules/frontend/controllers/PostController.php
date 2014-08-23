<?php

namespace tpoxa\cmars\modules\frontend\controllers;

use yii\web\Controller;
use tpoxa\cmars\models\Post;

class PostController extends Controller {

    public function actionView($alias) {

        $model = Post::getPostByAlias($alias);
        if ($model == null) {
            throw new \yii\web\HttpException(404, 'Page not found');
        }
        return $this->render($this->module->viewTemplate, ['model' => $model]);
    }

}
