<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<h1>Регистрация</h1>
<?php
if(isset($message)){
   echo $message;
}
$form = ActiveForm::begin();
?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'email')?>
<?=$form->field($model, 'partner_id')?>
<div class="form-group">
   <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary'])?>
</div>
<?php
ActiveForm::end();
?>
<p><a href="http://localhost/basic/web/index.php?r=site%2Fentry">Вы уже зарегистрированы? Войти в свой профиль</a></p>