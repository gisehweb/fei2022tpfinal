<?php

use yii\db\Migration;

/**
 * Class m220727_141227_crear_table_carrera
 */
class m220727_141227_crear_table_carrera extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%carrera}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(128)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%carrera}}');
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_141227_crear_table_carrera cannot be reverted.\n";

        return false;
    }
    */
}
