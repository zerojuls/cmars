<?php

namespace mtrofimenko\cmars\modules\backend\widgets\NestedList;

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use \yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class NestedList extends Widget {

    public $items;

    public function renderItems($items) {

        $result = [];
        foreach ($items as $i => $item) {
            $result[] = $this->renderItem($item);
        }
        Html::addCssClass($this->options, 'dd-list');
        unset($this->options['id']);

        $this->view->registerJs('$("#' . $this->id . '").nestable().on("change", function(){
                $.ajax(' . Json::encode([
                    'url' => Url::to(['save']),
                    'type' => 'post',
                    'data' => [
                        'data' => new JsExpression('window.JSON.stringify($(this).nestable("serialize"))')
                    ]
                ]) . ');
                
            });');

        return Html::tag('ol', implode("\n", $result), $this->options);
    }

    public function run() {
        if (sizeof($this->items) == 0) {
            return '<i>No menu items</i>';
        }
        echo Html::tag('div', $this->renderItems($this->items), ['class' => 'dd', 'id' => $this->id]);
    }

    public function renderItem($item) {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }

        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        Html::addCssClass($options, 'dd-item');
        Html::addCssClass($options, 'dd3-item');

        if ($items !== null) {
            $items = $this->renderItems($items);
        }
        NestedListAsset::register($this->view);
        return Html::tag('li', Html::tag('div', 'drag', ['class' => 'dd-handle dd3-handle']) .
                        Html::tag('div', $this->render('_content', ['item' => $item, 'options' => $options]), ['class' => 'dd3-content']) . $items, $options);
    }

}
