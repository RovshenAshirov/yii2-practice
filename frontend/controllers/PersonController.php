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
    public function actionIndex(): string
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

    /**
     * @throws Exception
     */
    public function actionSql(): string
    {
        $command = Yii::$app->db->createCommand('SELECT * FROM person');

        $result = $command->queryAll();
//        $result = $command->queryOne();
//        $result = $command->queryColumn();
//        $result = $command->queryScalar();

        return $this->render('sql', ['data' => $result]);
    }

    /**
     * @throws Exception
     */
    public function actionBind(): string
    {
        $sql = 'SELECT * FROM person WHERE first_name = :first_name OR last_name = :last_name';
        $command = Yii::$app->db->createCommand($sql);

//        $command->bindValue(':first_name', 'Rovshen');
//        $command->bindValue(':last_name', 'Ashirov');
        $command->bindValues([
            ':first_name' => 'Rovshen',
            ':last_name' => 'Ashirov'
        ]);

//        $first_name = 'Rovshen';
//        $last_name = 'Ashirov';
//        $command->bindParam(':first_name', $first_name);
//        $command->bindParam(':last_name', $last_name);
//        $data1 = $command->queryAll();
//
//        $first_name = 'Torebay';
//        $last_name = 'Dadebayev';
//        $command->bindParam(':first_name', $first_name);
//        $command->bindParam(':last_name', $last_name);
//        $data2 = $command->queryAll();

        $result = $command->queryAll();

        return $this->render('sql', ['data' => $result]);
    }

    /**
     * @throws Exception
     */
    public function update_gender($first_name, $gender): int
    {
        $sql = 'UPDATE person SET gender = :gender WHERE first_name = :first_name';
        if (in_array($gender, ['male', 'female'])) {
            return Yii::$app->db->createCommand($sql)->execute();
        }
        return 0;
    }

    /**
     * @throws Exception
     */
    public function insert($first_name, $last_name, $email, $gender): int
    {
        return Yii::$app->db->createCommand()->insert('person', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'gender' => $gender,
        ])->execute();
    }

    /**
     * @throws Exception
     */
    public function batchInsert($array): int
    {

        return Yii::$app->db->createCommand()->insert('person',
            ['first_name', 'last_name', 'email', 'gender'],
            $array
//            [
//                ['first_name1', 'last_name1', 'email1', 'gender1'],
//                ['first_name2', 'last_name2', 'email2', 'gender2'],
//                ['first_name3', 'last_name3', 'email3', 'gender3'],
//            ]
        )->execute();
    }

    /**
     * @throws Exception
     */
    public function transaction($sql1, $sql2)
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $db->createCommand($sql1)->execute();
            $db->createCommand($sql2)->execute();
            // ... executing other SQL statements ...

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}