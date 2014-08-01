<?php

namespace mtrofimenko\cmars;

use \Yii;
use yii\helpers\ArrayHelper;

class CMARS extends \yii\base\Module {

    public $controllerNamespace = 'mtrofimenko\cmars\controllers';
    public $app_id = 0;
    public $modelClasses = [];
    public $alias = '@cmars';
    public $enablePosts = true;
    public $enableRubrics = true;
    //
    protected $_models;

    //
    public function init() {
        parent::init();



        $this->modules = [
            'admin' => [
                'class' => 'mtrofimenko\cmars\modules\backend\CMARSBackend',
                'enablePosts' => $this->enablePosts,
                'enableRubrics' => $this->enableRubrics
            ],
            'frontend' => [
                'class' => 'mtrofimenko\cmars\modules\frontend\CMARSFrontend',
            ],
        ];

        if (!isset(Yii::$app->params['icon-framework'])) {
            Yii::$app->params['icon-framework'] = 'fa';
        }

        if (!isset(Yii::$app->params['languages'])) {
            Yii::$app->params['languages'] = [
                'en' => 'English',
            ];
        }
        if (!isset(Yii::$app->params['moreTag'])) {
            Yii::$app->params['moreTag'] = 'more';
        }


        \Yii::$app->setModule('gridview', [
            'class' => '\kartik\grid\Module'
        ]);

        $this->setI18(['posts', 'users', 'rubrics', 'pages']);
        $this->modelClasses = array_merge($this->getDefaultModelClasses(), $this->modelClasses);


        $this->setAliases([
            $this->alias => __DIR__,
        ]);
    }

    protected function getDefaultModelClasses() {
        // use single quotes so nothing gets escaped
        return [
            'Post' => 'mtrofimenko\cmars\models\Post',
            'Menu' => 'mtrofimenko\cmars\models\Menu',
            'Menuitem' => 'mtrofimenko\cmars\models\Menuitem',
            'MenuBuilder' => 'mtrofimenko\cmars\components\menuBuilder',
        ];
    }

    public function model($name, $config = []) {
        // return object if already created
        if (!empty($this->_models[$name])) {
            return $this->_models[$name];
        }



        // create model and return it
        $className = $this->modelClasses[ucfirst($name)];
        $this->_models[$name] = Yii::createObject(array_merge(["class" => $className], $config));
        return $this->_models[$name];
    }

    private function setI18($sections) {
        foreach ($sections as $section) {
            if (!isset(Yii::$app->i18n->translations[$section])) {
                Yii::$app->i18n->translations[$section] = [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/messages',
                        //'forceTranslation' => true,
                ];
            }
        }
    }

}
