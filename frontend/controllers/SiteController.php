<?php
namespace frontend\controllers;

use common\components\Helper;
use common\components\IpRateLimit;
use common\components\Pagination;
use common\components\SimpleNumericCaptchaAction;
use common\components\Translate;
use common\models\Category;
use common\models\Doctor;
use common\models\HelpInfo;
use common\models\Hospital;
use common\models\Menu;
use common\models\Page;
use common\models\Subscribe;
use Yii;
use yii\bootstrap\Html;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use frontend\models\SubscribeForm;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'add-subscribe' => ['post'],
                ],
            ],
            'subscribeRateLimiter' => [
                'class' => RateLimiter::className(),
                'only' => ['add-subscribe'],
                'user' => function () {
                    return new IpRateLimit([
                        'id' => Yii::$app->request->getUserIP(),
                        'limit' => 10,
                        'window' => 600,
                    ]);
                },
                'errorMessage' => Yii::t('frontend', 'Too many appointment attempts. Please try again later.'),
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
                'class' => SimpleNumericCaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? '1234' : null,
                'width' => 120,
                'height' => 48,
                'padding' => 7,
                'foreColor' => 0x173f20,
                'backColor' => 0xffffff,
                'testLimit' => 3,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $help_info = HelpInfo::find()
            ->orderBy(['order' => SORT_ASC])
            ->all();

        $brands = Hospital::find()
            ->where(['status' => 1, 'brand' => 1])
            ->orderBy(new Expression('rand()'))
            ->all();

        $services = Category::find()
            ->innerJoin('doctor_has_category','doctor_has_category.category_id=category.id')
            ->orderBy(['category.order' => SORT_ASC])
            ->groupBy('category.id')
            ->limit(24)
            ->all();

        $home_page = Page::findOne(['alias'=>'home-page']);
        $menu = Menu::find()->where(['url' => 'plastic-surgeon'])->orderBy(['order' => SORT_ASC])->one();

        return $this->render('index', [
            'help_info' => $help_info,
            'services' => $services,
            'brands' => $brands,
            'home_page' => $home_page,
            'menu' => $menu,
        ]);
    }

    /**
     * @return string
     */
    public function actionServices(){

        $services = Category::find()
            ->innerJoin('doctor_has_category','doctor_has_category.category_id=category.id')
            ->orderBy(['category.order' => SORT_ASC])
            ->groupBy('category.id')
            ->all();

        return $this->render('service', [
            'services' => $services,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage($alias)
    {

        $page = Page::findOne(['alias' => $alias]);

        if(empty($page)){
            throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
        }

        return $this->render('page', [
            'page' => $page,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSearch(){

        $post = Yii::$app->request->post();

        $search_text = Html::encode(str_ireplace('_', ' ', Yii::$app->request->get('search_text')));

        if($post)
        {
            $search_text = strip_tags(Yii::$app->request->post('search'));
            if (!empty($search_text))
            {
                $search_text = str_ireplace(' ', '_',  Html::encode($search_text));
                $search_uri = Html::encode($search_text);
                $this->redirect(Helper::lang('search/'.$search_uri));
            }
        }


        if(empty($search_text)){
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $query = Hospital::find()
            ->leftJoin('lang_has_hospital', 'lang_has_hospital.hospital_id=hospital.id')
            ->leftJoin('hospital_has_type', 'hospital_has_type.hospital_id=hospital.id')
            ->leftJoin('type', 'hospital_has_type.type_id = type.id')
            ->leftJoin('lang_has_type', 'lang_has_type.type_id=type.id')
            ->andFilterWhere([
                'or',
                ['like', 'hospital.alias', $search_text],
                ['like', 'lang_has_hospital.name', $search_text],
                ['like', 'lang_has_hospital.tiny_text', $search_text],
                ['like', 'lang_has_type.name', $search_text],
            ])->groupBy('hospital.id');
        $hospitals = $query->all();

        $query_doctor = Doctor::find()
            ->leftJoin('lang_has_doctor', 'lang_has_doctor.doctor_id=doctor.id')
            ->leftJoin('doctor_has_category', 'doctor_has_category.doctor_id=doctor.id')
            ->leftJoin('category', 'doctor_has_category.category_id = category.id')
            ->leftJoin('lang_has_category', 'lang_has_category.category_id=category.id')
            ->leftJoin('hospital_has_doctor', 'hospital_has_doctor.doctor_id=doctor.id')
            ->leftJoin('hospital', 'hospital_has_doctor.hospital_id = hospital.id')
            ->leftJoin('lang_has_hospital', 'lang_has_hospital.hospital_id=hospital.id')
            ->where(['doctor.status' => 1])
            ->andFilterWhere([
                'or',
                ['like', 'doctor.alias', $search_text],
                ['like', 'lang_has_doctor.full_name', $search_text],
                ['like', 'lang_has_doctor.doctor_info', $search_text],
                ['like', 'lang_has_doctor.tiny_text', $search_text],
                ['like', 'lang_has_category.name', $search_text],
                ['like', 'lang_has_hospital.name', $search_text],
                ['like', 'lang_has_hospital.tiny_text', $search_text],
            ])->groupBy('doctor.id');

        $doctors = $query_doctor->all();


        return $this->render('search', [
            'hospitals' => $hospitals,
            'doctors' => $doctors,
            'title' => $search_text,
        ]);

    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionAddSubscribe()
    {
        $form = new SubscribeForm();

        if (!$form->load(Yii::$app->request->post()) || !$form->validate()) {
            Yii::warning([
                'event' => 'appointment_rejected',
                'client' => $this->getClientFingerprint(),
                'invalidFields' => array_keys($form->getErrors()),
            ], 'security.appointment');
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'Please check the appointment form and try again.'));

            return $this->redirect('/');
        }

        if (!$this->resolveSubscribeTarget($form)) {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'The selected doctor or hospital is unavailable.'));
            return $this->redirect('/');
        }

        $duplicateKey = [
            'accepted-appointment',
            hash_hmac(
                'sha256',
                $form->phone . '|' . (int) $form->doctor_id . '|' . (int) $form->hospital_id,
                Yii::$app->request->cookieValidationKey
            ),
        ];

        if (!Yii::$app->cache->add($duplicateKey, true, 900)) {
            return $this->render('add-subscribe');
        }

        if (!$this->sendSubscribeToCrm($form)) {
            Yii::$app->cache->delete($duplicateKey);
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'There was an error sending your message.'));

            return $this->redirect('/');
        }

        $model = new Subscribe();
        $model->full_name = $form->full_name;
        $model->phone = $form->phone;
        $model->description = $form->description;
        $model->doctor = $form->doctorName;
        $model->hospital = $form->hospitalName;
        $model->date = date('Y-m-d H:i:s');
        $model->year = date('Y');
        $model->month = date('m');

        if (!$model->save()) {
            Yii::error([
                'event' => 'appointment_local_save_failed',
                'client' => $this->getClientFingerprint(),
            ], 'security.appointment');
        }

        return $this->render('add-subscribe');
    }

    private function resolveSubscribeTarget(SubscribeForm $form)
    {
        if (!empty($form->doctor_id)) {
            $doctor = Doctor::findOne(['id' => $form->doctor_id, 'status' => 1]);
            if ($doctor === null) {
                return false;
            }
            $form->doctorName = Translate::text($doctor->getLangHasDoctors(), 'full_name');
        }

        if (!empty($form->hospital_id)) {
            $hospital = Hospital::findOne(['id' => $form->hospital_id, 'status' => 1]);
            if ($hospital === null) {
                return false;
            }
            $form->hospitalName = Translate::text($hospital->getLangHasHospitals(), 'name');
        }

        return true;
    }

    private function sendSubscribeToCrm(SubscribeForm $form)
    {
        $url = Yii::$app->params['crmSubscribeUrl'];
        $key = Yii::$app->params['crmSubscribeKey'];
        $token = Yii::$app->params['crmSubscribeToken'];

        if (strncmp($url, 'https://', 8) !== 0 || $key === '' || $token === '') {
            Yii::error(['event' => 'appointment_crm_not_configured'], 'security.appointment');
            return false;
        }

        $fields = [
            'key' => $key,
            'format' => 'json',
            'ip' => Yii::$app->request->getUserIP(),
            'post' => [
                'token' => $token,
                'Subscribe' => [
                    'full_name' => $form->full_name,
                    'phone' => $form->phone,
                    'description' => (string) $form->description,
                    'doctor' => (string) $form->doctorName,
                    'hospital' => (string) $form->hospitalName,
                ],
            ],
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ];
        if (defined('CURLOPT_PROTOCOLS') && defined('CURLPROTO_HTTPS')) {
            $options[CURLOPT_PROTOCOLS] = CURLPROTO_HTTPS;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $httpStatus = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($result === false || $httpStatus < 200 || $httpStatus >= 300 || trim($result) !== 'success') {
            Yii::warning([
                'event' => 'appointment_crm_rejected',
                'httpStatus' => $httpStatus,
                'transportError' => $curlError === '' ? null : $curlError,
            ], 'security.appointment');
            return false;
        }

        return true;
    }

    private function getClientFingerprint()
    {
        return hash_hmac(
            'sha256',
            (string) Yii::$app->request->getUserIP(),
            Yii::$app->request->cookieValidationKey
        );
    }
}
