<?php

/* @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model app\models\Post
 * @var Post[] $posts
 * @var Post $post
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Мои посты';
?>

<?php
if ($posts) {
    foreach ($posts as $post):

        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><?=$post->theme?></h4>
                <h6 class="panel-title"><?=gmdate("H:i:s  d M Y ",$post->date )?></h6>
            </div>
            <div class="panel-body">
                <?=$post->value?>
            </div>
        </div>

    <?php endforeach;

} else echo '<h1>' . 'У вас нет Постов :(' . '</h1>'; ?>



<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'theme') ?>

<?= $form->field($model, 'value')->textArea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Опубликовать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end();
?>