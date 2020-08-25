<?php

namespace ityakutia\collective\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class CollectiveQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::class
        ];
    }

    /**
     * @return Collective[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @return Collective|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}