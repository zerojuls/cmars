<?php

namespace tpoxa\cmars\models;

use yii;
use yii\db\ActiveRecord;
use common\extensions\fileapi\behaviors\UploadBehavior;

class Post extends ActiveRecord {

    const STATUS_NEW = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 2;
    const STATUS_DELETED = 3;

    public $previewHeight = 640;
    public $previewWidth = 480;
    public $previewAllowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['alias', 'filter', 'filter' => 'trim', 'on' => ['admin-edit-page-static']],
            ['alias', 'required', 'on' => ['admin-edit-page-static']],
            ['alias', 'match', 'pattern' => '/^[a-z0-9_-]+$/', 'on' => ['admin-edit-page-static']],
            ['alias', 'string', 'min' => 3, 'max' => 64, 'on' => ['admin-edit-page-static']],
            ['alias', 'unique', 'on' => ['admin-edit-page-static']],
            ['status', 'required', 'on' => ['admin-edit-page-static']],
            ['status', 'in', 'range' => array_keys(self::getStatusArray()), 'on' => ['admin-edit-page-static']],
            ['author_id', 'required', 'on' => ['admin-edit-page-static']],
            ['author_id', 'integer', 'on' => ['admin-edit-page-static']],
            
            ['rubric_id', 'required', 'on' => ['admin-edit-page-static']],
            ['rubric_id', 'integer', 'on' => ['admin-edit-page-static']],
            ['published_date', 'string', 'on' => ['admin-edit-page-static']],
            ['add_preview_to_full', 'boolean', 'on' => ['admin-edit-page-static']],
            ['youtube_code', 'match', 'pattern' => '/^[a-z0-9]+$/', 'on' => ['admin-edit-page-static']],
            ['youtube_code', 'string', 'min' => 6, 'max' => 12, 'on' => ['admin-edit-page-static']],
            ['preview_img', 'string', 'on' => ['admin-edit-page-static']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => ['preview_img'],
                'scenarios' => ['admin-edit-page-static'],
                'deleteScenarios' => [
                //'image_url' => 'delete-image',
                //'preview_url' => 'delete-preview'
                ],
                'path' => [
                    //'image_url' => Post::imagePath(),
                    'preview_img' => Post::previewPath(),
                ],
                'tempPath' => [
                    //'image_url' => Post::imageTempPath(),
                    'preview_img' => Post::previewTempPath()
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return [
            'admin-edit-page-static' => [
                'alias',
                'status',
                'author_id',
             
                'rubric_id',
                'published_date',
                'add_preview_to_full',
                'youtube_code',
                'preview_img'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'alias' => Yii::t('posts', 'Alias'),
            'author_id' => Yii::t('posts', 'Author'),
            'rubric_id' => Yii::t('posts', 'Rubric'),
            'views' => Yii::t('posts', 'Views'),
            'type' => Yii::t('posts', 'Type'),
            'status' => Yii::t('posts', 'Status'),
            'published_date' => Yii::t('posts', 'Published date'),
            'add_preview_to_full' => Yii::t('posts', 'Add Preview'),
            'youtube_code' => Yii::t('posts', 'Youtube code')
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->views = 0;

                if (!$this->status) {
                    $this->status = self::STATUS_NEW;
                }
            }

            if (!$this->published_date) {
                $this->published_date = date('Y-m-d', time());
            }
            return true;
        }
        return false;
    }

    public static function getStatusArray() {
        return [
            self::STATUS_NEW => Yii::t('posts', 'New'),
            self::STATUS_ACTIVE => Yii::t('posts', 'Active'),
            self::STATUS_DISABLE => Yii::t('posts', 'Disable'),
            self::STATUS_DELETED => Yii::t('posts', 'Deleted'),
        ];
    }

    public function getTitle() {
        if ($this->id) {
            $model = PostTranslate::find()->where([
                        'post_id' => $this->id,
                        'language' => Yii::$app->language
                    ])->one();
        }
        return ($model !== null) ? $model->title : '';
    }

    public static function previewPath($image = null) {
        $path = '@webroot/statics/web/content/post/previews';
        if ($image !== null) {
            $path .= '/' . $image;
        }
        return Yii::getAlias($path);
    }

    public static function previewTempPath($image = null) {
        $path = '@webroot/statics/tmp/post/previews';
        if ($image !== null) {
            $path .= '/' . $image;
        }
        return Yii::getAlias($path);
    }

    public static function previewUrl($image = null) {
        $url = '/content/post/previews/';
        if ($image !== null) {
            $url .= $image;
        }
        if (isset(Yii::$app->params['staticsDomain'])) {
            $url = Yii::$app->params['staticsDomain'] . $url;
        }
        return $url;
    }

    public function getUrl() {
        return "/$this->alias.html";
    }

    public static function getPostByAlias($url) {
        preg_match("/[0-9a-zA-Z_-]+/", $url, $alias);
        if ($alias && is_array($alias)) {
            $sql = "SELECT p.id, pt.full_text, pt.title, pt.meta_title,
                    pt.meta_descriptions, pt.meta_keywords, pt.preview_text
                FROM " . Post::tableName() . " as p
                LEFT JOIN " . PostTranslate::tableName() . " as pt
                   ON p.id = pt.post_id
                WHERE pt.language = :lang
                    AND p.alias = :alias";
            return PostTranslate::findBySql($sql, [
                        ':lang' => Yii::$app->language,
                        ':alias' => current($alias)
                    ])->one();
            $serch = new PostSearch();
            $serch->search([]);
        }
        return false;
    }

}
