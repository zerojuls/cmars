<?php

use yii\db\Schema;
use mtrofimenko\cmars\models\Rubric;
use mtrofimenko\cmars\models\RubricTranslate;
use mtrofimenko\cmars\models\Post;
use mtrofimenko\cmars\models\PostTranslate;

class m140608_152727_posts_init extends \yii\db\Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }



        $this->createTable(Rubric::tableName(), [
            'id' => Schema::TYPE_PK,
           
            'name' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $tableOptions);

        $this->createTable(RubricTranslate::tableName(), [
            'id' => Schema::TYPE_PK,
            'rubric_id' => Schema::TYPE_INTEGER,
            'language' => Schema::TYPE_STRING . '(2)',
            'title' => Schema::TYPE_STRING . '(32) NOT NULL',
            'meta_title' => Schema::TYPE_TEXT,
            'meta_keywords' => Schema::TYPE_TEXT,
            'meta_descriptions' => Schema::TYPE_TEXT,
                ], $tableOptions);

        $this->createTable(Post::tableName(), [
            'id' => Schema::TYPE_PK,
            'rubric_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'section_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'views' => Schema::TYPE_INTEGER,
            'youtube_code' => Schema::TYPE_STRING . '(32)',
            'preview_img' => Schema::TYPE_STRING . '(32)',
            'status' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(64) NOT NULL',
            'published_date' => Schema::TYPE_INTEGER . ' NOT NULL',
            'add_preview_to_full' => Schema::TYPE_BOOLEAN,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                ], $tableOptions);
        $this->createIndex('alias', Post::tableName(), 'alias', true);

        $this->createTable(PostTranslate::tableName(), [
            'id' => Schema::TYPE_PK,
            'post_id' => Schema::TYPE_INTEGER . '(10) NOT NULL',
            'language' => Schema::TYPE_STRING . '(2)',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'full_text' => Schema::TYPE_TEXT . ' NOT NULL',
            'preview_text' => Schema::TYPE_TEXT,
            'meta_title' => Schema::TYPE_TEXT,
            'meta_keywords' => Schema::TYPE_TEXT,
            'meta_descriptions' => Schema::TYPE_TEXT,
                ], $tableOptions);

        $this->initTables();
    }

    public function down() {


        $this->dropTable(Rubric::tableName());
        $this->dropTable(RubricTranslate::tableName());

        $this->dropTable(Post::tableName());
        $this->dropTable(PostTranslate::tableName());
    }

    private function initTables() {
        
    }

}
