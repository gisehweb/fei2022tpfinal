<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[HorarioMateria]].
 *
 * @see HorarioMateria
 */
class HorarioMateriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return HorarioMateria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return HorarioMateria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
