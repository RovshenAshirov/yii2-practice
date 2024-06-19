<?php

namespace frontend\controllers;

use frontend\models\MyContact;
use yii\web\Controller;

class PostController extends Controller
{
    public $defaultAction = 'index';

    public function actionHello(): string
    {
        return $this->render('hello');
    }
    public function actionIndex(): string
    {
        $telegram = '@Oliy_dasturchi';
        $array = ['Rovshen', 'Ashirov', 'Yii'];
        return $this->render('index', ['telegram' => $telegram, 'array' => $array]);
    }

    public function actionMyContact()
    {
        $model = new MyContact();
        $model->email = 'Rovshen';
        $model->name = 'Ashirov';

        if ($model->validate()) {
            echo "Validatsiyadan o'tdi";
        } else {
//            echo "Validatsiyadan o'tmadi. Xatolik";
            print_r($model->errors);
        }
    }
}