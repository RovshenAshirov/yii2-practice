<?php

namespace frontend\controllers;

use frontend\models\PersonForm;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class PersonController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex()
    {
        $model = new PersonForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Write to database');
                $model = new PersonForm();
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}