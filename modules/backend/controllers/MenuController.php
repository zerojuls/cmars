<?php

namespace tpoxa\cmars\modules\backend\controllers;

use tpoxa\cmars\modules\backend\models\SwitchMenuForm;
use tpoxa\cmars\modules\backend\components\Controller;
use tpoxa\cmars\models\Menuitem;
use yii\helpers\Json;
use tpoxa\cmars\models\Menu;
use yii\web\HttpException;

class MenuController extends Controller {

    public function actionIndex($menu_id = null) {

        $menu_class = \Yii::$app->getModule('cms')->model('Menu');

        $model = $menu_id ? $menu_class::findOne($menu_id) : $menu_class::find()->where([
                    'app_id' => \Yii::$app->getModule('cms')->app_id
                ])->one();

        if ($model == null) {
            return $this->redirect(['create']);
        }

        $switchForm = new SwitchMenuForm;
        $switchForm->menu_id = $model->id;
        //
        if ($switchForm->load($_POST) && $switchForm->validate()) {
            $this->redirect(['index', 'menu_id' => $switchForm->menu_id]);
        }

        return $this->render('index', ['model' => $model, 'switchForm' => $switchForm]);
    }

    public function actionCreate() {
        $menu_class = \Yii::$app->getModule('cms')->model('Menu');
        //
        $model = new $menu_class;
        $model->app_id = \Yii::$app->getModule('cms')->app_id;
        if ($model->load($_POST) && $model->save()) {
            $this->redirect(['index', 'menu_id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionSave() {
        if (isset($_POST['data'])) {
            $data = Json::decode($_POST['data']);
           
            Menu::updateItems($data);
        }
    }

    public function actionEdit($id) {
        $model = Menuitem::findOne($id);
        if ($model == null) {
            throw new HttpException(404, 'Not found');
        }

        if ($model->load($_POST) && $model->save()) {
            $this->redirect(['index', 'menu_id' => $model->menu_id]);
        }

        return $this->renderPartial('edit', ['model' => $model]);
    }

    public function actionDelete($id) {
        if ($model = Menuitem::findOne($id)) {
            if ($model->delete()) {

                $this->redirect(['index', ['menu_id' => $model->menu_id]]);
            }
        }
    }

    public function getMenuSections($model) {
        $builder = \Yii::$app->getModule('cms')->model('MenuBuilder');

        $newLink = new Menuitem();
        $newLink->builder = $builder;
        $items = [];
        foreach ($builder->generateMenuSections() as $key => $section) {
            $items[] = ['label' => $section['label'], 'content' => $this->renderPartial('_selectOptions', [
                    'items' => $section['items'],
                    'section' => $key,
                    'model' => $newLink,
            ])];
        }



        $newLink->menu_id = $model->id;
        $newLink->parent_id = 0;
        if ($newLink->load(\Yii::$app->request->post()) && $newLink->save()) {

            \Yii::$app->session->setFlash('success', 'New menu item added');
            return $this->refresh();
        }

        $items[] = [
            'label' => 'Custom link',
            'content' => $this->renderPartial('_custom_link', ['model' => $newLink], true),
        ];
        return $items;
    }

}
