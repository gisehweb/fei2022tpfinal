<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva_aula".
 *
 * @property int $id
 * @property int $id_aula
 * @property string|null $fh_desde
 * @property string|null $fh_hasta
 * @property string $observacion
 *
 * @property Aula $aula
 * @property HorarioMateria[] $horarioMaterias
 */
class ReservaAula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aula', 'observacion'], 'required'],
            [['id_aula'], 'default', 'value' => null],
            [['id_aula'], 'integer'],
            [['fh_desde', 'fh_hasta'], 'safe'],
            [['observacion'], 'string', 'max' => 256],
            [['id_aula'], 'exist', 'skipOnError' => true, 'targetClass' => Aula::className(), 'targetAttribute' => ['id_aula' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aula' => 'Id Aula',
            'fh_desde' => 'Fh Desde',
            'fh_hasta' => 'Fh Hasta',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * Gets query for [[Aula]].
     *
     * @return \yii\db\ActiveQuery|AulaQuery
     */
    public function getAula()
    {
        return $this->hasOne(Aula::className(), ['id' => 'id_aula']);
    }

    /**
     * Gets query for [[HorarioMaterias]].
     *
     * @return \yii\db\ActiveQuery|HorarioMateriaQuery
     */
    public function getHorarioMaterias()
    {
        return $this->hasMany(HorarioMateria::className(), ['id_reserva' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaAulaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaAulaQuery(get_called_class());
    }
}
