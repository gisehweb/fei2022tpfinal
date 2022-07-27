<?php

use yii\db\Migration;

/**
 * Class m220727_144445_crear_table_reserva_aula
 */
class m220727_144445_crear_table_reserva_aula extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reserva_aula}}', [
            'id' => $this->primaryKey(),
            'id_aula' => $this->integer()->notNull(),
            'fh_desde' => $this->timestamp(),
            'fh_hasta' => $this->timestamp(),
            'observacion' => $this->string(256)->notNull()
        ]);

        $this->createIndex('idx-reserva_aula-id_aula','reserva_aula', 'id_aula');

        $this->addForeignKey('fk-reserva_aula-id_aula', 'reserva_aula', 'id_aula', 'aula', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-reserva_aula-id_aula', 'reserva_aula');
        $this->dropIndex('idx-reserva_aula-id_aula','reserva_aula');

        $this->dropTable('{{%reserva_aula}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_144445_crear_table_reserva_aula cannot be reverted.\n";

        return false;
    }
    */
}
