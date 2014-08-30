<?php

namespace tpoxa\cmars\modules\backend\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\HttpException;
use tpoxa\cmars\modules\backend\components\Controller;
use tpoxa\cmars\modules\backend\models\RubricSearch;
use tpoxa\cmars\models\Rubric;
use tpoxa\cmars\models\RubricTranslate;

class RubricsController extends Controller {

    public function actionIndex() {
        $searchModel = new RubricSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
                    'model' => $model,
                    'atributes' => $this->prepareDetailViewAttributes($id)
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lang = $this->prepareLang(Yii::$app->request->post());
            $translate = $this->getTranslateModel($id, $lang);
            if ($translate->load(Yii::$app->request->post()) && $translate->save()) {
                Yii::$app->session->setFlash('success', Yii::t('rubrics', 'Rubric \'{name}\' successfully updated', ['name' => $model->name]));
            }
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $translates = [];
            foreach (Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel($id, $lang);
            }

            return $this->render('update', [
                        'model' => $model,
                        'translates' => $translates,
                            ]
            );
        }
    }

    public function actionCreate() {
        $model = new Rubric();
        $model->app_id = \Yii::$app->getModule('cms')->app_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translate = new RubricTranslate();
            if ($translate->load(Yii::$app->request->post()) && $translate->validate()) {
                $translate->rubric_id = $model->id;
                $translate->save(false);
                Yii::$app->session->setFlash('success', Yii::t('rubrics', 'Rubric \'{name}\' successfully updated', ['name' => $model->name]));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $translates = [];
            foreach (Yii::$app->params['languages'] as $lang => $val) {
                $translates[] = $this->getTranslateModel(null, $lang);
            }

            return $this->render('create', [
                        'model' => $model,
                        'translates' => $translates,
                            ]
            );
        }
    }

    public function actionDelete($id) {
        if ($id == 1) {
            Yii::$app->session->setFlash('warning', Yii::t('rubrics', 'Rubric \'Static\' can not be removed'));
            return $this->redirect(['index']);
        }

        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('rubrics', 'Rubric \'{name}\' successfully removed', ['name' => $model->name]));
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (is_array($id)) {
            $model = Rubric::find()->where(['id' => $id])->all();
        } else {
            $model = Rubric::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }

    protected function getTranslateModel($id, $lang) {
        $translate = RubricTranslate::find()->where([
                    'rubric_id' => $id,
                    'language' => $lang,
                ])->one();
        if (!$translate) {
            $translate = new RubricTranslate();
            $translate->rubric_id = $id;
            $translate->language = $lang;
        }
        return $translate;
    }

    private function prepareDetailViewAttributes($id) {
        $translate = RubricTranslate::find()->where(['rubric_id' => $id])->all();
        $attributes = [];
        foreach ($translate as $val) {
            $attributes[] = [
                'label' => Yii::$app->params['languages'][$val->language],
                'attribute' => 'name',
                'format' => 'raw',
                'value' => $val->title,
            ];
        }
        return $attributes;
    }

    private function prepareLang($post) {
        return isset($post['RubricTranslate']['language']) ? $post['RubricTranslate']['language'] : '';
    }

}
