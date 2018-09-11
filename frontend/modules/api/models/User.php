<?php

namespace frontend\modules\api\models;

class User extends \common\models\User
{
    public function fields()
    {
        return ['id', 'name' => function(User $user) {
            return $user->username." ".User::STATS_LABELS[$user->status];
        }];
    }

    public function extraFields()
    {
        return ['projectUsers', 'projects'];
    }

}