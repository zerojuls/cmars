<?php

namespace tpoxa\cmars\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class PostTranslate extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%posts_translate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'full_text', 'language', 'post_id'], 'required'],
            ['title', 'string', 'max' => 64],
            ['full_text', 'string', 'max' => 4096],
            ['preview_text', 'string', 'max' => 1024],
            ['meta_title', 'safe'],
            ['meta_descriptions', 'safe'],
            ['meta_keywords', 'safe'],
            ['language', 'in', 'range' => array_keys(Yii::$app->params['languages'])],
            ['post_id', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => Yii::t('posts', 'Title'),
            'full_text' => Yii::t('posts', 'Full text'),
            'preview_text' => Yii::t('posts', 'Preview text'),
            'meta_title' => Yii::t('posts', 'Meta title'),
            'meta_descriptions' => Yii::t('posts', 'Meta descriptions'),
            'meta_keywords' => Yii::t('posts', 'Meta keywords'),
            'language' => Yii::t('posts', 'Language'),
            'post_id' => Yii::t('posts', 'Post'),
        ];
    }

}
