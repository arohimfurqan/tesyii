<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\UserSocialMedia;
use yii\helpers\Url;
use \yii\imagine\Image;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Anda tidak diizinkan untuk mengakses halaman ' . $action->id . ' ini!');
                },
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    // [
                    //     'allow' => true,
                    //     'matchCallback' => function ($rule, $action) {
                    //         $moduleID = $action->controller->module->id;
                    //         $controllerID = $action->controller->id;
                    //         $actionID = $action->id;
                    //         $userID = \Yii::$app->user->id;
                    //         $auth = \app\models\Auth::find()
                    //             ->where([
                    //                 'module' => $moduleID,
                    //                 'controller' => $controllerID,
                    //                 'action' => $actionID,
                    //                 'user_id' => $userID,
                    //             ])
                    //             ->count();
                    //         if ($auth > 0) return true;
                    //     }

                    // ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        // call safeAttributes method for properly format data
        $attributes = $this->safeAttributes($client);

        // find data social media in basis data
        $user_social_media = UserSocialMedia::find()
            ->where([
                'social_media' => $attributes['social_media'],
                'id' => (string)$attributes['id'],
                'username' => $attributes['username'],
            ])
            ->one();

        // if data found
        if ($user_social_media) {
            // get user from relation
            $user = $user_social_media->user;
            // check user is active
            if ($user->status == User::STATUS_ACTIVE) {
                // do automatic login
                Yii::$app->user->login($user);
            } else {
                Yii::$app->session->setFlash('error', 'Login gagal, status user tidak aktif');
            }
            // finish
        } else {
            // if data not found
            // check if email social media exists in tabel user
            $user = User::find()
                ->where([
                    'email' => $attributes['email']
                ])
                ->one();
            // if user found
            if ($user) {
                // check user is active
                if ($user->status == User::STATUS_ACTIVE) {
                    // add to table user social media
                    $user_social_media = new UserSocialMedia([
                        'social_media' => $attributes['social_media'],
                        'id' => (string)$attributes['id'],
                        'username' => $attributes['username'],
                        'user_id' => $user->id,
                    ]);
                    $user_social_media->save();

                    // do automatic login
                    Yii::$app->user->login($user);
                } else {
                    Yii::$app->session->setFlash('error', 'Login gagal, status user tidak aktif');
                }
            } else {
                // check if social media not twitter
                if ($attributes['social_media'] != 'twitter') {
                    // do automatic signup
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $attributes['username'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    if ($user->save()) {
                        $user_social_media = new UserSocialMedia([
                            'social_media' => $attributes['social_media'],
                            'id' => (string)$attributes['id'],
                            'username' => $attributes['username'],
                            'user_id' => $user->id,
                        ]);
                        $user_social_media->save();
                        // do automatic login
                        Yii::$app->user->login($user);
                    } else {
                        Yii::$app->session->setFlash('error', 'Login gagal, galat saat registrasi');
                    }
                } else {
                    // save data attributes to session
                    $session = Yii::$app->session;
                    $session['attributes'] = $attributes;

                    // redirect to signup, via property successUrl
                    $this->action->successUrl = Url::to(['signup']);
                }
            }
        }
    }

    public function safeAttributes($client)
    {
        // get user data from client
        $attributes = $client->getUserAttributes();
        // print_r($attributes);
        // exit;

        // set default value
        $safe_attributes = [
            'social_media' => '',
            'id' => '',
            'username' => '',
            'name' => '',
            'email' => '',
        ];

        // get value from user attributes base on social media
        if ($client instanceof \yii\authclient\clients\Facebook) {
            $safe_attributes = [
                'social_media' => 'facebook',
                'id' => $attributes['id'],
                'username' => $attributes['email'],
                'name' => $attributes['name'],
                'email' => $attributes['email'],
            ];
        } else if ($client instanceof \yii\authclient\clients\Google) {
            $safe_attributes = [
                'social_media' => 'google',
                'id' => $attributes['id'],
                'username' => $attributes['email'],
                'name' => $attributes['name'],
                'email' => $attributes['email'],
            ];
        } else if ($client instanceof \yii\authclient\clients\Twitter) {
            $safe_attributes = [
                'social_media' => 'twitter',
                'id' => $attributes['id'],
                'username' => $attributes['screen_name'],
                'name' => $attributes['name'],
                'email' => '-',
            ];
        } else if ($client instanceof \yii\authclient\clients\GitHub) {
            $safe_attributes = [
                'social_media' => 'github',
                'id' => $attributes['id'],
                'username' => $attributes['login'],
                'name' => $attributes['name'],
                'email' => $attributes['email'],
            ];
        }
        return $safe_attributes;
    }



    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionKomentar()
    {

        $model = new \app\models\Komentar();

        $data = [
            'model' => $model
        ];

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                Yii::$app->session->setFlash('success', 'Terima kasih ');
            } else {
                Yii::$app->session->setFlash('error', 'Maaf, salah!');
            }
            return $this->render('hasil_komentar', $data);
        } else {
            return $this->render('hello', $data);
        }
    }

    public function actionQuery()
    {
        $db = Yii::$app->db;
        $command = $db->createCommand('SELECT * FROM employee');
        // $employees = $command->queryAll();
        //Ekstrak data
        foreach ($command->queryAll() as $employee) {
            echo "<br>";
            echo $employee['id'] . " ";
            echo $employee['name'] . " ";
            echo "(" . $employee['age'] . ") ";
        }
    }


    public function actionQuery2()
    {
        $db = Yii::$app->db;
        // return a single row 
        $employee = $db->createCommand('SELECT * FROM employee WHERE id=:tesid', ['tesid' => 2])->queryOne();
        echo $employee['id'] . " ";
        echo $employee['name'] . " ";
        echo "(" . $employee['age'] . ") ";
        echo "<hr>";
        // return a single column (the first column)
        $names = $db->createCommand('SELECT name FROM employee')
            ->queryColumn();
        print_r($names);
        echo "<hr>";
        // return a scalar
        $count = $db->createCommand('SELECT COUNT(*) FROM employee')
            ->queryScalar();
        echo "Jumlah employee " . $count;
        echo "<hr>";
    }


    public function actionSignup()
    {
        $model = new \app\models\SignupForm();

        // use session
        $session = Yii::$app->session;
        $attributes = $session['attributes'];

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($session->has('attributes')) {
                    // add data user_social_media
                    $user_social_media = new UserSocialMedia([
                        'social_media' => $attributes['social_media'],
                        'id' => (string)$attributes['id'],
                        'username' => $attributes['username'],
                        'user_id' => $user->id,
                    ]);
                    $user_social_media->save();
                }

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        if ($session->has('attributes')) {
            // set form field with data from social media
            $model->username = $attributes['username'];
            $model->email = $attributes['email'];
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionUpload()
    {
        $user_id = \Yii::$app->user->id;
        $model = \app\models\UserPhoto::find()->where([
            'user_id' => $user_id
        ])->one();

        if (!$model) {
            $model = new \app\models\UserPhoto([
                'user_id' => $user_id
            ]);
        }

        if (\Yii::$app->request->post()) {
            $model->photo = \yii\web\UploadedFile::getInstance($model, 'photo');
            if ($model->validate()) {
                $saveTo = 'uploads/' . $model->photo->baseName . '.' . $model->photo->extension;
                $tmb = 'uploads/' . 'tmb-' . $model->photo->baseName . '.' . $model->photo->extension;

                if ($model->photo->saveAs($saveTo)) {
                    $model->save(false);
                    Yii::$app->session->setFlash('success', 'Foto berhasil diupload');
                    $image  = Image::thumbnail($saveTo, 60, 45);
                    $image->save(Yii::getAlias($tmb), ['quality' => 50]);
                }
            }
        }

        return $this->render('upload', [
            'model' => $model
        ]);
    }

    public function actionGallery()
    {

        $user_id = \Yii::$app->user->id;


        $model = new \app\models\Gallery();
        if (\Yii::$app->request->post()) {
            $model->images = \yii\web\UploadedFile::getInstances($model, 'images');
            if ($model->validate()) {
                foreach ($model->images as $file) {
                    $saveTo = 'uploads/' . $file->baseName . '.' . $file->extension;
                    if ($file->saveAs($saveTo)) {
                        $model2 = new \app\models\Gallery([
                            'images' => $file->baseName . '.' . $file->extension,
                            'user_id' => $user_id,
                        ]);
                        $model2->save(false);
                    }
                }
                \Yii::$app->session->setFlash('success', 'Image berhasil di upload');
            }
        }
        $model3 = \app\models\Gallery::find()->where([
            'user_id' => $user_id
        ])->all();

        return $this->render('galleryf', [
            'model' => $model,
            'model3' => $model3
        ]);
    }


    public function actionDownload($inline = false)
    {
        $user_id = \Yii::$app->user->id;
        $model = \app\models\Gallery::find()->where([
            'user_id' => $user_id
        ])->one();
        $path = Yii::getAlias("@app") . '/uploads/';
        $file_download = $path . $model->images;
        $fake_filename = $model->images;
        $response = Yii::$app->getResponse();
        $response->sendFile($file_download, $fake_filename, ['inline' => $inline]);
    }

    public function actionChart()
    {
        $db = \Yii::$app->db;
        $years = $db->createCommand('
        SELECT DISTINCT(year) FROM survey_framework
        ORDER BY year ASC')
            ->queryColumn();

        $frameworks = $db->createCommand('
        SELECT * FROM framework
        ORDER BY id ASC')
            ->queryAll();
        $series = [];
        foreach ($frameworks as $framework) {
            $results = $db->createCommand('
            SELECT total FROM survey_framework
            WHERE framework_id=' . $framework['id'] . '
            ORDER BY year ASC')
                ->queryColumn();
            $data = array_map('intval', $results);
            $series[] = [
                'name' => $framework['nama_framework'],
                'data' => $data,
            ];
        }

        return $this->render('chartbook', [
            'years' => $years,
            'series' => $series,
        ]);
    }

    public function actionEmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom('botriski1@gmail.com')
            ->setTo('rohim98@gmail.com')
            ->setSubject('Uji coba aja')
            ->setTextBody('Teks yang tampil di body')
            ->setHtmlBody('<b>Contoh text HTML</b>')
            ->send();
    }

    public function actionMaintenance()
    {
        return $this->render('maintenance');
    }


    public function actionDataCache()
    {
        $var4 = "Teks ini akan disimpan di cache tergantung dari file dependency.txt";
        $cache = \Yii::$app->cache;
        $data = $cache->get('var4');
        if ($data === false) {
            $dependency = new \yii\caching\FileDependency([
                'fileName' => '@runtime/cache/dependency.txt',
            ]);
            $cache->set('var4', $var4, 0, $dependency);
            $data = $var4;
        }
        echo $data;
    }
}
