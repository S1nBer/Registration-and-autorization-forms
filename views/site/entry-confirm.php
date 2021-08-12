<?php
use yii\helpers\Html;
?>
<h1>Ваши персональные данные:</h1>
<ul>
<li>Вас зовут: <?=Html::encode($model->name)?></li>
<li><label>Email:</label> <?=Html::encode($model->email)?></li>
<li>Ваш партерский id: <?=Html::encode($model->partner_id)?></li>
<?php 
if(isset($ancestor->partner_id)){
   echo '<li>Партерский id вышестоящего: ' .Html::encode($ancestor->partner_id).'</li>';
}
?>
</ul>