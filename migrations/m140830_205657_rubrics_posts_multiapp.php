<?php

use yii\db\Schema;
use yii\db\Migration;

class m140830_205657_rubrics_posts_multiapp extends Migration {

    public function up() {

        $this->addColumn(\tpoxa\cmars\models\Post::tableName(), 'app_id', 'INT NOT NULL');
        $this->addColumn(\tpoxa\cmars\models\Rubric::tableName(), 'app_id', 'INT NOT NULL');
        $this->dropColumn(\tpoxa\cmars\models\Post::tableName(), 'section_id');
    }

    public function down() {

        $this->addColumn(\tpoxa\cmars\models\Post::tableName(), 'section_id', 'INT NOT NULL');
        $this->dropColumn(\tpoxa\cmars\models\Post::tableName(), 'app_id');
        $this->dropColumn(\tpoxa\cmars\models\Rubric::tableName(), 'app_id');
        return true;
    }

}
