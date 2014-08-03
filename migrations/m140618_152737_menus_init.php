<?php

use yii\db\Schema;
use tpoxa\cmars\models\Menu;
use tpoxa\cmars\models\Menuitem;

/*



  CREATE TABLE IF NOT EXISTS `menuitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `type` varchar(32) NOT NULL,
  `sortIdx` int(11) NOT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

  -- --------------------------------------------------------

  --
  -- Структура таблицы `menus`
  --

  CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `description` varchar(32) NOT NULL,
  `app_id` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

 */

class m140608_152727_posts_init extends \yii\db\Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }



        $this->createTable(Menuitem::tableName(), [
            'id' => Schema::TYPE_PK,
            'menu_id' => Schema::TYPE_INTEGER,
            'parent_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING . '(100) NOT NULL',
            'url' => Schema::TYPE_STRING . '(100) NOT NULL',
            'type' => Schema::TYPE_STRING . '(32) NOT NULL',
            'sortIdx' => Schema::TYPE_INTEGER,
                ], $tableOptions);

        $this->createTable(Menu::tableName(), [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(24) NOT NULL',
            'description' => Schema::TYPE_STRING . '(32) NOT NULL',
            'app_id' => Schema::TYPE_STRING . '(32) NOT NULL',
                ], $tableOptions);
    }

    public function down() {


        $this->dropTable(Menu::tableName());
        $this->dropTable(Menuitem::tableName());
    }

}
