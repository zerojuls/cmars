<?php

namespace mtrofimenko\cmars\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class RubricTranslate extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%rubrics_translate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'required'],
            ['title', 'string', 'min' => 3, 'max' => 64],
            ['language', 'required'],
           // ['language', 'in', 'range' => array_keys(Yii::$app->params['languages'])],
            ['rubric_id', 'integer'],
            ['meta_title', 'string'],
            ['meta_keywords', 'string'],
            ['meta_descriptions', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'rubric_id' => Yii::t('rubrics', 'Rubric'),
            'language' => Yii::t('rubrics', 'Language'),
            'title' => Yii::t('rubrics', 'Title'),
            'meta_title' => Yii::t('rubrics', 'Meta title'),
            'meta_keywords' => Yii::t('rubrics', 'Meta keywords'),
            'meta_descriptions' => Yii::t('rubrics', 'Meta descriptions'),
        ];
    }

}
