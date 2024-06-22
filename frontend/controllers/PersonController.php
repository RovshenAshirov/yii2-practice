<?php

namespace frontend\controllers;

use common\models\Person;
use frontend\models\PersonForm;
use Yii;
use yii\db\Exception;
use yii\db\Query;
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

    public function actionAdd(): string
    {
        $person = new Person();
        if ($person->load(Yii::$app->request->post())) {
            if ($person->save()) {
                Yii::$app->session->setFlash('success', 'Write to database');
                $this->redirect('person/index');
            }
        }

        return $this->render('create', ['person' => $person]);
    }

    public function actionQuery(): string
    {
        $query = (new Query())->from('person')->one();
        $user = Person::find()->one();

        return $this->render('query', ['query' => $query, 'user' => $user]);
    }

    public function actionFind()
    {
        $person = Person::find()->one();

        // SELECT * FROM 'person' WHERE 'id' = 2;
        // $person = Person::findOne(2);

        // SELECT * FROM 'person' WHERE 'id' = 2 AND email = 'r@gmail.com';
        // $person = Person::findOne([
        //     'id' => 2,
        //     'email' => 'r@gmail.com',
        // ]);

        // SELECT * FROM 'person' WHERE id IN (2, 3);
        $person = Person::findAll([2, 3]);

        // SELECT * FROM 'person' WHERE email = 'r@gmail.com';
        // $person = Person::findAll(['email' => 'r@gmail.com']);

        // $person = Person::find()->where(['email' => 'r@gmail.com'])->all();

        // $email = 'r@gmail.com';
        // $sql = "SELECT * FROM person WHERE email = :email";
        // $person = Person::findBySql($sql, ['email' => $email])->asArray()->all();

        echo '<pre>';
        print_r($person);
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

    public function actionQueryBuilder()
    {
        $query = new Query();

        $rows = $query
            // SELECT *
            ->select('*')
            // FROM person
            ->from('person')
            ->all();
        // ->one();
        // ->column();
        // ->scalar();
        // ->count();

        // SELECT
        // ->select('email, first_name')
        // ->select(['email', 'first_name'])
        // ->select(['email AS e', 'first_name'])

        // FROM
        // ->from('person p')

        // WHERE
        // WHERE id=2 AND email="something@gmail.com"
        // ->where('id = :id AND email = :email', [':id' => 2, ':email' => 'something@gmail.com'])
        // ->where(['id' => 2, 'email' => 'something@gmail.com'])  // AND
        // ->where(['AND', 'id=2', 'email="something@gmail.com"'])
        // WHERE email="something@gmail.com" AND (country="USA" OR country="UK")
        // ->where(['AND', 'email="something@gmail.com"', ['OR', 'country="USA"', 'country="UK"'])
        // WHERE NOT id=2
        // ->where('NOT', 'id=2')
        // WHERE NOT (id=2 AND email="something@gmail.com")
        // ->where(['NOT', 'id=2', 'email="something@gmail.com"'])
        // WHERE id BETWEEN 1 AND 10
        // ->where('BETWEEN', 'id', 1, 10)
        // WHERE id NOT BETWEEN 1 AND 10
        // ->where('NOT BETWEEN', 'id', 1, 10)
        // WHERE id IN (1, 2, 3, 4)
        // ->where('IN', 'id', [1, 2, 3, 4])
        // WHERE email LIKE '%ema%'
        // ->where('LIKE', 'email', 'ema')
        // WHERE email LIKE '%ema'
        // ->where('LIKE', 'email', '%ema', false)
        // WHERE age > 30
        // ->where('>', 'age', 30)

        // andWhere() and orWhere()
        // WHERE status = 1
        // WHERE status = 1 AND title LIKE '%kitob%'
        $query->where(['status' => 1]);

        if (!empty($search_word)) {
            $query->orWhere(['LIKE', 'title', $search_word]);
        }

        // ORDER BY
        // ->orderBy('id ASC, email DESC')
        // ->orderBy(['id' => SORT_ASC, 'email' => SORT_DESC])

        // GROUP BY
        // ->groupBy('id, email')

        // LIMIT, OFFSET
        // ->limit(10)->offset(10)

        // JOIN
        // ->join('INNER JOIN', 'post', 'post.category_id = category.id')
        // ->leftJoin('post', 'post.category_id = category.id')

        echo '<pre>';
        // print_r($rows->createCommand()->sql); // without all();
        print_r($rows);

        die();
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