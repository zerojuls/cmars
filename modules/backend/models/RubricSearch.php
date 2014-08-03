<?php

namespace tpoxa\cmars\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use tpoxa\cmars\models\Rubric;
use tpoxa\cmars\models\RubricTranslate;

class RubricSearch extends Model {

    public $name;
    public $title;
    public $recordsPerPage = 10;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'title'], 'string'],
        ];
    }

    public function search($params) {
        $query = Rubric::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->recordsPerPage,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->leftJoin(RubricTranslate::tableName() . ' as tr ', '' .
                Rubric::tableName() . '.id = tr.rubric_id AND tr.language = \'' . Yii::$app->language . '\''
        );
        $query->andWhere(['like', 'tr.title', $this->title]);
        $query->andWhere(['like', Rubric::tableName() . '.name', $this->name]);

        return $dataProvider;
    }

}
