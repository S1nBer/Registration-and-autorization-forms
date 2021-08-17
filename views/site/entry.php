<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1>Авторизация</h1>

<?php
$form = ActiveForm::begin();
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php
ActiveForm::end();
?>
<p>
    <a href="/site/registration">Вы не зарегистрированы? Создайте аккаунт</a>
</p>