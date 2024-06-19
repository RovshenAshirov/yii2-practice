<?php

namespace frontend\controllers;

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
}