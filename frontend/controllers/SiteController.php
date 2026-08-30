<?php
namespace frontend\controllers;

use common\components\Helper;
use common\components\Pagination;
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
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

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
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
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
    public function actionAddSubscribe(){

        $post = Yii::$app->request->post();


        if(!empty($post)){

            $headers = array(
                'Content-Type: application/json',
            );

            $fields = array(
                'key' => '4444',
                'format' => 'json',
                'ip' => $_SERVER['REMOTE_ADDR'],
                'post' => $post,
            );
            $url = 'https://crm.doctor911.am/site/add-subscribes?' . http_build_query($fields);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);

            curl_close($ch);

            if ($result == 'success') {

                $model = new Subscribe();
                $model->date = date('Y-m-d H:i:s');
                $model->year = date('Y');
                $model->month = date('m');

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->render('add-subscribe', []);
                }
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->redirect('/');

        }else{
            throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
        }


    }
}
