<?php
/* @var $model app\models\Post
 * @var $pagination yii\data\Pagination
 * @var $this yii\web\View
 * @var $posts app\models\Post[]
 * @var $post app\models\Post
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title = 'Главная';

?>
<div class="site-index">

    <?php
    if ($posts) {
        foreach ($posts as $post):
            ?>

            <div class="media">
                <a class="pull-left" href="<?=Url::toRoute('user/show?id='.$post->user->id)?>">
                    <img class="media-object" src="<?= $post->user->thumb_image ?>">
                </a>

                <div class="media-body">
                    <h3><?= $post->user->name . "  " . $post->user->surname ?></h3>
                    <h6><?= gmdate("H:i:s M d Y ",$post->date ) ?></h6>
                    <h4 class="media-heading"><?= Html::encode($post->theme) ?></h4>
                    <?= Html::encode($post->value) ?>
                </div>
            </div>

        <?php endforeach;
    } ?>


    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
