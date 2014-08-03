<?php

namespace tpoxa\cmars\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menuitems".
 *
 * @property integer $id
 * @property integer $menu_id
 */
class Menuitem extends \yii\db\ActiveRecord {

    private $_builder;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menuitems';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'string'],
            [['title', 'url'], 'safe'],
            [['menu_id'], 'required'],
            [['menu_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'type' => 'Link',
        ];
    }

    public function getItems() {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])->where(['menu_id' => $this->menu_id])->orderBy('sortIdx asc');
    }

    public function getItemsMenu() {
        $menu = [];
        $builder = \Yii::$app->getModule('cms')->model('MenuBuilder');
        foreach ($this->getItems()->all() as $item) {
            $item->builder = $builder;
            $menu[] = ['label' => $item->getTitle(), 'url' => $item->getUrl(), 'options' => ['data-id' => $item->id], 'items' => $item->getItemsMenu()];
        }
        return $menu;
    }

    public function afterDelete() {
        foreach ($this->getItems()->all() as $item) {
            $item->delete();
        }
    }

    public function getUrl() {
        if ($this->type == 'custom') {
            return $this->url;
        }

        $items = $this->_builder->getItems();
        // var_dump($items, $this->type);
        return ArrayHelper::getValue($items, $this->type);
    }

    public function getTitle() {
        return $this->title;
    }

    public function setBuilder($builder) {
        return $this->_builder = $builder;
    }

}
