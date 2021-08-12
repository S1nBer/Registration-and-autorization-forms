<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h1>Авторизация</h1>
<?php
if(isset($message)){
   echo $message;
}
$form = ActiveForm::begin();
?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'email')?>
<div class="form-group">
   <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary'])?>
</div>
<?php
ActiveForm::end();
?>
<p><a href="http://localhost/basic/web/index.php?r=site%2Fregistration">Вы не зарегистрированы? Создайте аккаунт</a></p>