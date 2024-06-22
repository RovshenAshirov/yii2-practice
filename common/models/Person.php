<?php

namespace common\models;

use yii\db\ActiveRecord;

class Person extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{person}}';
    }

    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'email', 'gender'], 'required'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 50],
            ['email', 'email'],
            ['gender', 'in', 'range' => ['male', 'female']],
        ];
    }
}