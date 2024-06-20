<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'person-form',
    'options' => ['class' => 'form-horizontal'],
]);

echo $form->field($model, 'first_name');
echo $form->field($model, 'last_name');
echo $form->field($model, 'email')->input('email');
echo $form->field($model, 'gender')->dropDownList([
    'male' => 'Male',
    'female' => 'Female'
],
[
    'prompt' => 'Select gender'
]);
echo Html::submitButton('Submit', ['class' => 'btn btn-success']);

ActiveForm::end();
