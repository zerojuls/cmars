<?php

namespace tpoxa\cmars\models;

use tpoxa\cmars\models\Menuitem;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "menus".
 *
 * @property integer $id
 * @property string $description
 */
class Menu extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%menus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['description'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    public function getDescription2() {
        return $this->description ? $this->description . '[' . $this->name . ']' : $this->name;
    }

    public function getItems() {

        return $this->hasMany(Menuitem::className(), ['menu_id' => 'id'])->where(['parent_id' => 0])->orderBy('sortIdx asc');
    }

    public function getItemsMenu() {
        $menu = [];
        $builder = \Yii::$app->getModule('cms')->model('MenuBuilder');

        foreach ($this->getItems()->all() as $item) {
            $item->builder = $builder;
            $_item = ['label' => $item->title, 'url' => $item->getUrl(), 'options' => ['data-id' => $item->id]];
            $items = $item->getItemsMenu();
            if (sizeof($items)) {
                $_item['items'] = $items;
            }
            $menu[] = $_item;
        }
        return $menu;
    }

    public static function MenuItems($name) {


        if ($model = self::find()->where(['name' => $name, 'app_id' => \Yii::$app->getModule('cms')->app_id])->one()) {
            return $model->getItemsMenu();
        }
    }

    public static function updateItems($items, $parent_id = 0) {

        $i = 1;
        foreach ($items as $key => $item) {

            if ($_item = Menuitem::findOne($item['id'])) {
                $_item->sortIdx = $i++;
                $_item->parent_id = $parent_id;
                $_item->save();
            }
            if (isset($item['children'])) {
                return self::updateItems($item['children'], $item['id']);
            }
        }
    }

}
