<?php

?>
<?= $form->field($model, 'title_seo')->textInput(['maxlength' => 300, 'class' => 'col-xs-10 col-sm-8']) ?>
<?= $form->field($model, 'content_seo')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 170]) ?>
<?= $form->field($model, 'key_seo')->textarea(['class' => 'autosize-transition form-control limited', 'maxlength' => 160]) ?>