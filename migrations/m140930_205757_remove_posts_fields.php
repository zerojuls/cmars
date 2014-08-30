<?php

use yii\db\Schema;
use yii\db\Migration;

class m140930_205757_remove_posts_fields extends Migration {

    public function up() {


        $this->dropColumn(\tpoxa\cmars\models\Post::tableName(), 'preview_img');
        $this->dropColumn(\tpoxa\cmars\models\Post::tableName(), 'youtube_code');
    }

    public function down() {

        $this->addColumn(\tpoxa\cmars\models\Post::tableName(), 'preview_img', 'varchar(32) NULL');
        $this->addColumn(\tpoxa\cmars\models\Post::tableName(), 'youtube_code', 'varchar(32) NULL');
        return true;
    }

}
