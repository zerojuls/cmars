<?php

namespace mtrofimenko\cmars\components;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class menuBuilder extends Model {

    public function getItems() {
        return [];
    }

    public function generateMenuSections() {
        return [
        ];
    }

    public function getSectionItems($section) {
        $items = $this->getItems();
        return ArrayHelper::getValue($items, $section, []);
    }

}
