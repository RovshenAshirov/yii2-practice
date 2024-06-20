<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;

class PersonForm extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $gender;

    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'email', 'gender'], 'required'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 50],
            ['email', 'email'],
            ['gender', 'in', 'range' => ['male', 'female']],
        ];
    }

    /**
     * @throws Exception
     */
    public function save(): int
    {
        $sql = "INSERT INTO person (first_name, last_name, email, gender) VALUES (:first_name, :last_name, :email, :gender)";
        $values = [
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':email' => $this->email,
            ':gender' => $this->gender,
        ];

        return Yii::$app->db->createCommand($sql)->bindValues($values)->execute();
    }
}