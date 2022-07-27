<?php

use yii\db\Migration;

/**
 * Class m220727_144800_crear_table_horario_materia
 */
class m220727_144800_crear_table_horario_materia extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%horario_materia}}', [
            'id' => $this->primaryKey(),
            'id_materia' => $this->integer()->notNull(),
            'id_reserva' => $this->integer()->Null(),
            'fh_desde' => $this->timestamp(),
            'fh_hasta' => $this->timestamp()
        ]);

        $this->createIndex('idx-horario_materia-id_materia','horario_materia', 'id_materia');
        $this->createIndex('idx-horario_materia-id_reserva','horario_materia', 'id_reserva');

        $this->addForeignKey('fk-horario_materia-id_materia', 'horario_materia', 'id_materia', 'materia', 'id', 'CASCADE');
        $this->addForeignKey('fk-horario_materia-id_reserva', 'horario_materia', 'id_reserva', 'reserva_aula', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-horario_materia-id_materia', 'horario_materia');
        $this->dropForeignKey('fk-horario_materia-id_reserva', 'horario_materia');

        $this->dropIndex('idx-horario_materia-id_materia','horario_materia');
        $this->dropIndex('idx-horario_materia-id_reserva','horario_materia');

        $this->dropTable('{{%horario_materia}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_144800_crear_table_horario_materia cannot be reverted.\n";

        return false;
    }
    */
}
