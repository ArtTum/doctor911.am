<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 9/18/2018
 * Time: 2:04 PM
 */

namespace frontend\controllers;


use common\components\Helper;
use common\components\Translate;
use common\models\Category;
use common\models\Comment;
use common\models\Doctor;
use common\models\DoctorHasCategory;
use common\models\Hospital;
use frontend\models\ContactForm;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class DoctorsController extends BaseController
{

    /**
     * @return string
     */
    public function actionIndex(){

        $post_hospital_alias = Yii::$app->request->post('hospital');
        $get_hospital_alias = Yii::$app->request->get('hospital');

        $post_profession_alias = Yii::$app->request->post('profession');
        $get_profession_alias = Yii::$app->request->get('profession');

        if (!empty($post_hospital_alias) && !empty($post_profession_alias)){
            return $this->redirect('/doctors/hospital-'.$post_hospital_alias.'/profession-'.$post_profession_alias);
        }elseif(!empty($post_hospital_alias)){
            return $this->redirect('/doctors/hospital-'.$post_hospital_alias);
        }


        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }

        $doctors = Doctor::find()
            ->where(['status' => 1])
            ->orderBy(['doctor.alias' => SORT_ASC]);

        $hospital = Hospital::findOne(['alias' => $get_hospital_alias]);
        if ($get_hospital_alias){

            $doctors = $doctors->joinWith(['hospitalHasDoctors'])
                ->andWhere(['hospital_has_doctor.hospital_id' => $hospital->id]);

            $professions = DoctorHasCategory::find()
                ->where(['doctor_id' => ArrayHelper::map($doctors->all(), 'id', 'id')])
                ->groupBy('category_id')
                ->all();

        }

        if ($get_profession_alias){

            $category = Category::findOne(['alias' => $get_profession_alias]);
            $doctors = $doctors->joinWith(['doctorHasCategories'])
                ->andWhere(['doctor_has_category.category_id' => $category->id]);
        }


        $query = $doctors;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 16]);
        $pages->pageSizeParam = false;
        $doctors = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $hospitals = Hospital::find()->where(['status' => 1])->all();


        return $this->render(Yii::$app->request->isAjax ? '_items' : 'index', [
            'doctors' => $doctors,
            'pages' => $pages,
            'count' => $countQuery->count(),
            'all' => $countQuery->all(),
            'title' => Yii::t('frontend','Doctors'),
            'alias' => 'doctors',
            'hospitals' => $hospitals,
            'professions' => $professions??[],
            'hospital_' => $hospital,
            'category' =>  $category,

        ]);

    }


    /**
     * @return string
     */
    public function actionPlasticSurgeon(){

        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }

        $doctors = Doctor::find()
            ->where(['plastic_surgeon' => 1])
            ->andWhere(['status' => 1])
            ->orderBy(['doctor.alias' => SORT_ASC]);

        $query = $doctors;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 200]);
        $pages->pageSizeParam = false;
        $doctors = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render(Yii::$app->request->isAjax ? '_items' : 'index', [
            'doctors' => $doctors,
            'pages' => $pages,
            'count' => $countQuery->count(),
            'all' => $countQuery->all(),
            'title' => Yii::t('frontend', 'Plastic Surgeons'),
            'alias' => 'plastic-surgeon',
        ]);

    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGallery($alias){

        $doctor = $this->findModel($alias);

        return $this->render('gallery', [
            'doctor' => $doctor,
        ]);
    }



    /**
     * @param $alias
     * @return string
     */
    public function actionServiceDoctor($alias){

        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }
        $category = Category::findOne(['alias' => $alias]);

        $doctors = Doctor::find()
            ->where(['doctor_status' => 1])
            ->innerJoin('doctor_has_category','doctor_has_category.doctor_id=doctor.id')
            ->where(['doctor_has_category.category_id' => $category->id])
            ->orderBy(['doctor.alias' => SORT_ASC])
            ->groupBy('doctor.id');

        $query = $doctors;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 16]);
        $pages->pageSizeParam = false;
        $doctors = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render(Yii::$app->request->isAjax ? '_items' : 'index', [
            'doctors' => $doctors,
            'pages' => $pages,
            'count' => $countQuery->count(),
            'category' => $category,
            'title' => Translate::text($category->getLangHasCategories(), 'name'),
        ]);

    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDoctor($alias){

        $model = new Comment();
        $doctor = $this->findModel($alias);

        $comments = Comment::find()
            ->where(['status' => 1])
            ->andWhere(['doctor_id' => $doctor->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $model->doctor_id = $doctor->id;
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for leaving comment'));

            return $this->redirect(['/doctor/'. $doctor->alias]);
        }


        return $this->render('doctor', [
            'model' => $model,
            'doctor' => $doctor,
            'comments' => $comments,
        ]);
    }

    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $alias
     * @return Doctor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Doctor::findOne(['status' => 1, 'alias' => $alias])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
    }

}
