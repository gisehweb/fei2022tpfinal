<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ReservaAula]].
 *
 * @see ReservaAula
 */
class ReservaAulaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReservaAula[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReservaAula|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
