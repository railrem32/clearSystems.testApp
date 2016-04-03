<?php
/* @var $model app\models\User */
namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use app\models\LoginForm;
use yii\filters\AccessControl;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;

/**
 * SecurityController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'register', 'profile'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'profile'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionRegister()
    {
        $model = new User;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->email = $model->email;
            $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->password = $hash;
            if (!User::findOne(['email' => $user->email])) {
                $dir = Yii::getAlias('image/avatar/');
                $user->image = '/' . $dir . "default.jpg";
                $user->thumb_image = '/' . $dir . "thumbs/default.jpg";
                $user->save();
                Yii::$app->user->login($user);
                return $this->goHome();
            } else {
                $model->addError('email', 'Пользователя с таким логином уже зарегистрирован');
            }
        }
        return $this->render('register', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        $user = new User();
        if ($model->load(Yii::$app->request->post())) {
            if ($user->login($model)) {
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile()
    {
        $success = false;

        $model = Yii::$app->user->identity;
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->city_id = $post['User']['city_id'];

            $file = UploadedFile::getInstance($model, 'file');
            if ($file && $file->tempName) {
                $model->file = $file;
                $current_image = $model->image;

                if (file_exists(Yii::getAlias('@webroot' . $current_image))) {
                    //удаляем файл
                    unlink(Yii::getAlias('@webroot' . $current_image));
                    unlink(Yii::getAlias('@webroot' . $model->thumb_image));
                    $model->image = '';
                    $model->thumb_image = '';
                }
                if ($model->validate(['file'])) {

                    $dir = Yii::getAlias('image/avatar/');
                    $fileName = $model->file->baseName . $this->generateRandomString() . '.' . $model->file->extension;
                    $model->file->saveAs($dir . $fileName);
                    $model->file = $fileName;
                    $model->image = '/' . $dir . $fileName;
                    $model->thumb_image = '/' . $dir . "thumbs/" . $fileName;

                    $photo = Image::getImagine()->open($dir . $fileName);
                    $photo->thumbnail(new Box(800, 800))->save($dir . $fileName, ['quality' => 90]);
                    Image::thumbnail($dir . $fileName, 80, 80)
                        ->save(Yii::getAlias($dir . 'thumbs/' . $fileName), ['quality' => 80]);
                }
            }

            if ($model->save()) {
                $success = true;
            };
        }
        return $this->render('profile', ['model' => $model, 'success' => $success]);

    }


    function generateRandomString($length = 6)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}
