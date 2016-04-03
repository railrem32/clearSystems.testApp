<?php
/* @var $user app\models\User */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Post;
use yii\filters\AccessControl;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mypost'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['mypost'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMypost()
    {
        $user = $model = Yii::$app->user->identity;
        $posts = $user->posts;
        $model = new Post;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_id = $user->getId();
            $model->date = time()+ 3600*3;
            if (!$model->save()) {
                $model->addError('theme', 'не удалось сохранить');
            };
            array_push($posts, $model);
        }


        return $this->render('mypost', [
            'posts' => $posts, 'model' => $model,
        ]);
    }


}