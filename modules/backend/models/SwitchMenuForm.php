<?php

namespace mtrofimenko\cmars\modules\backend\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use mtrofimenko\cmars\models\Menu;
use mtrofimenko\cmars\CMARS;
class SwitchMenuForm extends Model {

    public $menu_id;
  

    public function rules() {
        return [
            ['menu_id', 'required'],
        ];
    }

    public function getItems() {
        $app_id = \Yii::$app->getModule('cms')->app_id;
     
        return ArrayHelper::map(Menu::find()->where(['app_id' => (string)$app_id])->all(), 'id', 'description2');
    }

}
