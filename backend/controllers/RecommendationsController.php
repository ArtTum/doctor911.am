<?php

namespace app\controllers;

use app\components\Helper;
use app\models\SmsBaza;
use app\models\SmsHistory;
use Yii;
use app\models\Services;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecommendationsController implements the CRUD actions for Services model.
 */
class RecommendationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }



    /**
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Services();

        $post = Yii::$app->request->post();

        if ($model->load($post)) {

            $smsBrokerUrl = getenv('SMS_BROKER_URL') ?: '';
            $smsBrokerLogin = getenv('SMS_BROKER_LOGIN') ?: '';
            $smsBrokerPassword = getenv('SMS_BROKER_PASSWORD') ?: '';
            if (strncmp($smsBrokerUrl, 'https://', 8) !== 0 || $smsBrokerLogin === '' || $smsBrokerPassword === '') {
                Yii::error('SMS broker HTTPS credentials are not configured.', 'security.sms');
                Yii::$app->session->setFlash('error', 'SMS service is not configured.');
                return $this->refresh();
            }

            $phone = str_replace(["-", '', '.', ',', ' '], "", $post['Services']['phone']);
            $phone_text = $post['Services']['additional_data'];

            $xmlLogin = htmlspecialchars($smsBrokerLogin, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $xmlPassword = htmlspecialchars($smsBrokerPassword, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $xmlPhone = htmlspecialchars($phone, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $xmlText = htmlspecialchars($phone_text, ENT_XML1 | ENT_QUOTES, 'UTF-8');


            $envelope= '<?xml version="1.0" encoding="UTF-8"?>

            <bulk-request login="'.$xmlLogin.'" password="'.$xmlPassword.'" ref-id="'.date('Y-m-d H:i:s').'" delivery-notification-requested="true" version="1.0">
            
              <message id="'.$model->id.'" msisdn="'.$xmlPhone.'" service-number="Doctor911am" defer-date="'.date('Y-m-d H:i:s').'" validity-period="3" priority="1">
            
               <content type="text/plain">'.$xmlText.'</content>
            
              </message>
            
            </bulk-request>';

            $header = array(
                "Content-type:text/xml; charset=\"utf-8\"",
            );

            $MSAPI_Call = curl_init();
            //Change the following URL to point to production instead of integration
            curl_setopt($MSAPI_Call, CURLOPT_URL, $smsBrokerUrl);
            curl_setopt($MSAPI_Call, CURLOPT_TIMEOUT, 30);
            curl_setopt($MSAPI_Call, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($MSAPI_Call, CURLOPT_POST, true);
            curl_setopt($MSAPI_Call, CURLOPT_POSTFIELDS, $envelope);
            curl_setopt($MSAPI_Call, CURLOPT_HTTPHEADER, $header);
            curl_setopt($MSAPI_Call, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($MSAPI_Call, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($MSAPI_Call, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            if (defined('CURLOPT_PROTOCOLS') && defined('CURLPROTO_HTTPS')) {
                curl_setopt($MSAPI_Call, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
            }

            $response = curl_exec($MSAPI_Call);
            $err = curl_error($MSAPI_Call);
            curl_close($MSAPI_Call);
            //Call Parse Function for the XML response
            $result = simplexml_load_string($response);
            $out = $this->xml2array ( $result, $out = array () );

            $m = new SmsHistory();
            $m->year = date('Y');
            $m->month = date('m');
            $m->sms_date = date('Y-m-d H:i:s');
            $m->phone = $post['Services']['phone'];
            $m->sms_text = $phone_text;
            $m->save();


            return $this->redirect(['/']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    function xml2array ($xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
        {
            $out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;
        }
        return $out;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionJson(){

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (Yii::$app->request->isAjax){
            $datatable = ! empty( $_REQUEST[ 'datatable' ] ) ? $_REQUEST[ 'datatable' ] : array();
            $datatable = array_merge( array( 'pagination' => array(), 'sort' => array(), 'query' => array() ), $datatable );


            $sort  = ! empty( $datatable[ 'sort' ][ 'sort' ] ) ? $datatable[ 'sort' ][ 'sort' ] : 'desc';
            $field = ! empty( $datatable[ 'sort' ][ 'field' ] ) ? $datatable[ 'sort' ][ 'field' ] : 'id';

            $page    = ! empty( $datatable[ 'pagination' ][ 'page' ] ) ? (int)$datatable[ 'pagination' ][ 'page' ] : 1;
            $perpage = ! empty( $datatable[ 'pagination' ][ 'perpage' ] ) ? (int)$datatable[ 'pagination' ][ 'perpage' ] : -1;

            $filter = isset( $datatable[ 'query' ][ 'generalSearch' ] ) && is_string( $datatable[ 'query' ][ 'generalSearch' ] ) ? $datatable[ 'query' ][ 'generalSearch' ] : '';
            $pages = 1;

            $year = isset( $datatable[ 'query' ][ 'Year' ] ) && is_string( $datatable[ 'query' ][ 'Year' ] ) ? $datatable[ 'query' ][ 'Year' ] : date("Y");
            $month = isset( $datatable[ 'query' ][ 'Month' ] ) && is_string( $datatable[ 'query' ][ 'Month' ] ) ? $datatable[ 'query' ][ 'Month' ] : date("m");
            $color = isset( $datatable[ 'query' ][ 'Color' ] ) && is_string( $datatable[ 'query' ][ 'Color' ] ) ? $datatable[ 'query' ][ 'Color' ] : '';


            $session = Yii::$app->session;
            Yii::$app->session->get('filter-session');

            if($session->isActive){
                $item_session = [
                    'year' => $year,
                    'month' => $month,
                    'color' => $color,
                    'filter' => $filter
                ];

                Yii::$app->session->set('filter-session', $item_session);
            }

            $i = ($page*$perpage) - $perpage;

            $date = str_replace(["․", '.'], "․", $filter);
            $date2 = str_replace(["․", '.'], ".", $filter);

            $q = Services::find()
                ->where(['delete' => Yii::$app->request->get('deleted')])
                ->andWhere(['!=', 'type', 'hospitals-base'])
                ->andFilterWhere([
                    'or',
                    ['like', 'phone', $date],
                    ['like', 'other_phone', $date],
                    ['like', 'call_date', $date],
                    ['like', 'departure_datetime', $date],
                    ['like', 'additional_data', $date],
                    ['like', 'disease', $date],
                    ['like', 'medical_and_doctor', $date],
                    ['like', 'patient_full_name', $date],

                    ['like', 'phone', $date2],
                    ['like', 'other_phone', $date2],
                    ['like', 'call_date', $date2],
                    ['like', 'departure_datetime', $date2],
                    ['like', 'additional_data', $date2],
                    ['like', 'disease', $date2],
                    ['like', 'medical_and_doctor', $date2],
                    ['like', 'patient_full_name', $date2],
                ]);
            if (!empty($month)){
                $q = $q->andWhere(['month' => $month]);
            }
            if (!empty($year)){
                $q = $q->andWhere(['year' => $year]);
            }
            if (!empty($color)){
                $q = $q->andWhere(['color' => $color]);
            }
            $questionnaire = $q
                ->offset($i)
                ->limit($perpage)
                ->orderBy([$field => $sort == 'asc' ? SORT_ASC : SORT_DESC] )
                ->all();
            $total = $q->count();
            (($field == 'id') && ($sort == 'asc')) ? $i = $total - $i + 1 : $i;
            $data = [];
            foreach ($questionnaire as $model){
                (($field == 'id') && ($sort == 'asc')) ? --$i : $i++;
                $data[] =     (object) [
                    'ID' => $model->id,
                    'id' => $i,
                    'call_date' => $model->call_date,
                    'departure_datetime' => $model->departure_datetime,
                    'additional_data' => $model->additional_data,
                    'phone' => $model->phone .'<br>' .$model->other_phone ,
                    'sms_phone' => (int) str_replace(["-", '', '.', ',', ' '], "", substr($model->phone, 0)),
                    'other_phone' => $model->other_phone,
                    'full_name' => $model->patient_full_name,
                    'disease' => $model->disease,
                    'medical_and_doctor' => $model->medical_and_doctor,
                    'color' => $model->color
                ];
            }

            // $perpage 0; get all data
            if ( $perpage > 0 ) {
                $pages  = ceil( $total / $perpage ); // calculate total pages
                $page   = max( $page, 1 ); // get 1 page when $_REQUEST['page'] <= 0
                $page   = min( $page, $pages ); // get last page when $_REQUEST['page'] > $totalPages

                $data = array_slice( $data, 0, $perpage, true );
            }

            $meta = array(
                'page'    => $page,
                'pages'   => $pages,
                'perpage' => $perpage,
                'total'   => $total,
            );

            $result = array(
                'meta' => $meta + array(
                        'sort'  => $sort,
                        'field' => $field,
                    ),
                'data' => $data,
            );

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->data  =  $result;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $sms_baza = new SmsBaza();
            $sms_baza->year = $model->year;
            $sms_baza->month = $model->month;
            $sms_baza->call_date = $model->call_date;
            $sms_baza->phone = $model->phone;
            $sms_baza->other_phone = $model->other_phone;
            $sms_baza->patient_full_name = $model->patient_full_name;
            $sms_baza->disease = $model->disease;
            $sms_baza->medical_and_doctor = $model->medical_and_doctor;
            $sms_baza->save();

            return $this->redirect(['/recommendations']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($post['Services']['day_surgery'] && !$model->day_surgery) {
            $post['Services']['color'] = '#0070C0';
        }

        if ($model->load($post) && $model->save()) {

            $sms_baza = new SmsBaza();
            $sms_baza->year = $model->year;
            $sms_baza->month = $model->month;
            $sms_baza->call_date = $model->call_date;
            $sms_baza->phone = $model->phone;
            $sms_baza->other_phone = $model->other_phone;
            $sms_baza->patient_full_name = $model->patient_full_name;
            $sms_baza->disease = $model->disease;
            $sms_baza->medical_and_doctor = $model->medical_and_doctor;
            $sms_baza->save();

            return $this->redirect(['/recommendations']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionOutgoing($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {

            $sms_baza = new SmsBaza();
            $sms_baza->phone = $model->phone;
            $sms_baza->patient_full_name = $model->patient_full_name;
            $sms_baza->disease = $model->disease;
            $sms_baza->medical_and_doctor = $model->medical_and_doctor;
            $sms_baza->save();

            return $this->redirect(['/incoming/update','id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCopy($id) {

        $model = $this->findModel($id);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Services model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $deleted = Yii::$app->request->get('deleted');
        $model = $this->findModel($id);
        $model->delete = $deleted;
        $model->save();
        return $this->redirect(['/recommendations']);
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
