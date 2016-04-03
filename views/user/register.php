<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Регистрация';
?>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
      <h2>Регистрация</h2>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'password_repeat')->passwordInput() ?>


    <div class="form-group" align="center">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
