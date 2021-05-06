<?php

namespace api\models;

class User extends \common\models\User
{
    public function fields()
    {
        $fields = parent::fields();

        $availableFields = [
            'id',
            'created_at',
            'bonus_id'
        ];

        return array_filter($fields, function ($field) use ($availableFields) {
            return in_array($field, $availableFields);
        });
    }
}