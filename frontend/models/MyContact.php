<?php

namespace frontend\models;

use yii\base\Model;

class MyContact extends Model
{
    public string $name;
    public string $email;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}