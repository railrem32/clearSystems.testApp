<?php
/* @var $model app\models\User */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\City;
$this->title = 'Профиль';
$params = [
    'prompt' => 'Укажите Ваш город'
];
$cities = City::find()->all();
$items = ArrayHelper::map($cities, 'id', 'name');
?>

<div class="row">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?php
        if (isset($model->image) && file_exists(Yii::getAlias('@webroot', $model->image))) {
            echo Html::img($model->image, ['class' => 'img-responsive']);
        }
        ?>
        <?= $form->field($model, 'file')->fileInput(['placeholder'=>'Загрузить']) ?>


    </div>
    <div class="col-md-4">


        <?= $form->field($model, 'name')->textInput(['value' => $model->name]) ?>

        <?= $form->field($model, 'surname')->textInput(['value' => $model->surname]) ?>

        <?= $form->field($model, 'phone')->textInput(['value' => $model->phone]) ?>

        <?= $form->field($model, 'city_id')->dropDownList($items, $params, ['selected' => $model->city]) ?>
        <?php if ($success) {
            echo "<div class=\"alert alert-success\">Данные успешно обновлены</div>";
        } ?>
        <div class="form-group" align="center">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>