<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aula".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $ubicacion
 * @property int|null $cant_proyector
 * @property int|null $aforo
 * @property bool|null $es_climatizada
 *
 * @property ReservaAula[] $reservaAulas
 */
class Aula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'ubicacion'], 'required'],
            [['cant_proyector', 'aforo'], 'default', 'value' => null],
            [['cant_proyector', 'aforo'], 'integer'],
            [['es_climatizada'], 'boolean'],
            [['descripcion', 'ubicacion'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'ubicacion' => 'Ubicacion',
            'cant_proyector' => 'Cant Proyector',
            'aforo' => 'Aforo',
            'es_climatizada' => 'Es Climatizada',
        ];
    }

    /**
     * Gets query for [[ReservaAulas]].
     *
     * @return \yii\db\ActiveQuery|ReservaAulaQuery
     */
    public function getReservaAulas()
    {
        return $this->hasMany(ReservaAula::className(), ['id_aula' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AulaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AulaQuery(get_called_class());
    }
}
