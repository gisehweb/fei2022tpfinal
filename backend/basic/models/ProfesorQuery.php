<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Profesor]].
 *
 * @see Profesor
 */
class ProfesorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Profesor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Profesor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
