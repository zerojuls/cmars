<?php

use yii\db\Schema;
use yii\db\Migration;

class m140730_203657_sortingattributemenuitem extends Migration {

    public function up() {
        $this->addColumn(\tpoxa\cmars\models\Menuitem::tableName(), 'sortIdx', 'INT NOT NULL');
    }

    public function down() {
        $this->dropColumn(\tpoxa\cmars\models\Menuitem::tableName(), 'sortIdx');
        return true;
    }

}
