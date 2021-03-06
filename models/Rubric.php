<?php

namespace tpoxa\cmars\models;

use yii;
use yii\db\ActiveRecord;

class Rubric extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%rubrics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/'],
            ['name', 'string', 'min' => 3, 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('rubrics', 'Name'),
        ];
    }

    public function getTitle() {
        if ($this->id) {
            $model = RubricTranslate::find()->where([
                        'rubric_id' => $this->id,
                        'language' => Yii::$app->language
                    ])->one();
        }
        return ($model !== null) ? $model->title : '';
    }

    public static function getRubricsForSelect($app_id = 0) {
        $sections = [];
        $sql = "SELECT s.id, st.title
                FROM " . Rubric::tableName() . " as s
                LEFT JOIN " . RubricTranslate::tableName() . " as st
                   ON s.id = st.rubric_id
                WHERE st.language = :lang and s.app_id = :app_id
                    
        ";
        $models = RubricTranslate::findBySql($sql, [
                    ':lang' => Yii::$app->language,
                    ':app_id' => $app_id,
                ])->all();
        foreach ($models as $model) {
            $sections[$model->id] = $model->title;
        }


        return $sections;
    }

    public function getUrl() {
        return '';
    }

}
