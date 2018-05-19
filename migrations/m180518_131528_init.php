<?php

use yii\db\Migration;

class m180518_131528_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sensor}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'sn' => $this->string(),
            'fw' => $this->string(),
            'conn_fw' => $this->string(),
            'active' => $this->integer(3),
            'mode' => $this->integer(3),
            'controller_ip' => $this->string(),
        ], $tableOptions);

        $this->addCommentOnColumn('sensor', 'sn', 'серийний номер');
        $this->addCommentOnColumn('sensor', 'fw', 'версия прошивки контроллера');
        $this->addCommentOnColumn('sensor', 'conn_fw', 'версия прошивки модуля связи');
        $this->addCommentOnColumn('sensor', 'active', 'состояние активации');
        $this->addCommentOnColumn('sensor', 'mode', 'режим работы контроллера');
        $this->addCommentOnColumn('sensor', 'controller_ip', 'IP контроллера');

        $this->createTable('{{%sensor_card}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'number' => $this->string(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->addCommentOnColumn('sensor_card', 'number', 'номер карты');
        $this->addCommentOnColumn('sensor_card', 'status', 'статус');

        $this->createTable('{{%sensor_events}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'event' => $this->integer(),
            'card' => $this->string(),
            'time' => $this->string(),
            'flag' => $this->integer(),
        ], $tableOptions);

        $this->addCommentOnColumn('sensor_events', 'event', 'тип события');
        $this->addCommentOnColumn('sensor_events', 'card', 'номер карти');
        $this->addCommentOnColumn('sensor_events', 'time', 'время события');
        $this->addCommentOnColumn('sensor_events', 'flag', 'флаги собития');
    }

    public function safeDown()
    {
        $this->dropTable('{{%sensor}}');
        $this->dropTable('{{%sensor_card}}');
        $this->dropTable('{{%sensor_events}}');
    }
}
