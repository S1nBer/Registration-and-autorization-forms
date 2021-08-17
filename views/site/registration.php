<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h1>Регистрация</h1>
<?php
$form = ActiveForm::begin();
?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'email')?>
<?=$form->field($model, 'partnerId')?>
<div class="form-group">
   <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary'])?>
</div>
<?php
ActiveForm::end();
?>
<p><a href="/site/entry">Вы уже зарегистрированы? Войти в свой профиль</a></p>