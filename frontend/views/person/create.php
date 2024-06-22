<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'person-form',
    'options' => ['class' => 'form-horizontal'],
]);

echo $form->field($person, 'first_name');
echo $form->field($person, 'last_name');
echo $form->field($person, 'email')->input('email');
echo $form->field($person, 'gender')->dropDownList([
    'male' => 'Male',
    'female' => 'Female'
],
    [
        'prompt' => 'Select gender'
    ]);
echo Html::submitButton('Submit', ['class' => 'btn btn-success']);

ActiveForm::end();
