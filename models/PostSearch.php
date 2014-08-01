<?php

namespace mtrofimenko\cmars\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mtrofimenko\cmars\models\Post;

class PostSearch extends Model {

    public $alias;
    public $author_id;
    public $rubric_id;
    public $views;
    public $status;
    public $title;
    public $recordsPerPage = 10;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['alias', 'string'],
            ['title', 'string'],
            ['views', 'integer'],
            ['author_id', 'integer'],
            ['status', 'in', 'range' => array_keys(Post::getStatusArray())],
        ];
    }

    public function search($params) {
        $query = Post::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage
            ]
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->leftJoin(PostTranslate::tableName() . ' as tr ', '' .
                Post::tableName() . '.id = tr.post_id AND tr.language = \'' . Yii::$app->language . '\''
        );
        $query->andWhere(['like', 'tr.title', $this->title]);


        $this->addCondition($query, 'alias', true);
        $this->addCondition($query, 'views', true);
        $this->addCondition($query, 'status', true);
        $this->addCondition($query, 'author_id', true);

        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false) {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }

}
