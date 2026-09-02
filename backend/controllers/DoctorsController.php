<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\Translate;
use common\controllers\AuthController;
use common\models\Category;
use common\models\DoctorHasCategory;
use common\models\DoctorHasLibrary;
use common\models\Hospital;
use common\models\HospitalHasDoctor;
use common\models\Lang;
use common\models\LangHasDoctor;
use common\models\LangHasLibrary;
use Gumlet\ImageResize;
use Yii;
use common\models\Doctor;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DoctorsController implements the CRUD actions for Doctor model.
 */
class DoctorsController extends AuthController
{

    /**
     * Lists all Doctor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Doctor::find()
             //   ->where(['plastic_surgeon' => 0])
                ->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Gumlet
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Doctor();
        $model_lang = new LangHasDoctor();
        $model_hospital = new HospitalHasDoctor();
        $model_category = new DoctorHasCategory();
        $modelLibery = new DoctorHasLibrary();

        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        $model->name_alias = !empty($post['Doctor']['alias'])
            ? $post['Doctor']['alias']
            : ($post['lang']['full_name_1'] ?? null);
        $upload = UploadedFile::getInstance($model, 'image');

        $data_hospital = [];
        $data_category = [];
        $data = [];

        $hospitals = Hospital::find()->all();

        foreach ($hospitals as $hospital){
            $data_hospital[$hospital->id] = Translate::text($hospital->getLangHasHospitals(), 'name');
        }

        $categories = Category::findAll(['status' => 1]);

        foreach ($categories as $category){
            $data_category[$category->id] = Translate::text($category->getLangHasCategories(), 'name');
        }

        $data = $this->getLibraryData();

        if ($model->load($post) && $model->save()) {

            $libery_id = Yii::$app->request->post('library_id');

            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }

            $model_lang->add($post, $lang, $model->id);
            $model_hospital->add($post["HospitalHasDoctor"]['hospital_id'] ?? [], $model->id);
            $model_category->add($post["DoctorHasCategory"]['category_id'] ?? [], $model->id);
            $modelLibery->add($libery_id, $model->id);

            return $this->redirect(['/doctors']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
                'model_hospital' => $model_hospital,
                'data_hospital' => $data_hospital,
                'model_category' => $model_category,
                'data_category' => $data_category,
                'value' => [],
                'data' => $data,
            ]);
        }
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Gumlet\ImageResize
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasDoctor();
        $modelHas = $this->findModelHas($id);

        $model_hospital = new HospitalHasDoctor();
        $model_category = new DoctorHasCategory();
        $modelLibery = new DoctorHasLibrary();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = !empty($post['Doctor']['alias'])
            ? $post['Doctor']['alias']
            : ($post['lang']['full_name_1'] ?? null);
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;

        $data_hospital = [];
        $data_category = [];
        $data = [];
        $value = [];

        $hospitals = Hospital::find()->all();

        foreach ($hospitals as $hospital){
            $data_hospital[$hospital->id] = Translate::text($hospital->getLangHasHospitals(), 'name');
        }

        $categories = Category::findAll(['status' => 1]);

        foreach ($categories as $category){
            $data_category[$category->id] = Translate::text($category->getLangHasCategories(), 'name');
        }

        $data = $this->getLibraryData();

        foreach($modelHas as $item){
            $value[] = $item->library_id;
        }

        if ($model->load($post)) {


            $libery_id = Yii::$app->request->post('library_id');

            if (!empty($upload)) {
                $model->image = $upload->name;
            } else {
                $model->image = $lastImage;
            }
            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }

            $modelLibery->remove($model->id);
            $modelLibery->add($libery_id, $model->id);

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);

            $model_hospital->remove($model->id);
            $model_hospital->add($post["HospitalHasDoctor"]['hospital_id'] ?? [], $model->id);

            $model_category->remove($model->id);
            $model_category->add($post["DoctorHasCategory"]['category_id'] ?? [], $model->id);

            return $this->redirect(['/doctors']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
                'model_hospital' => $model_hospital,
                'data_hospital' => $data_hospital,
                'model_category' => $model_category,
                'data_category' => $data_category,
                'value' => $value,
                'data' => $data,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/doctors']);
    }

    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Doctor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doctor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     * @throws NotFoundHttpException
     */
    protected function findModelHas($id)
    {
        if (($model = DoctorHasLibrary::find()->where(['doctor_id' => $id])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getLibraryData()
    {
        $languageId = Lang::find()
            ->select('id')
            ->where(['iso' => Yii::$app->language])
            ->scalar();

        if ($languageId === false) {
            return [];
        }

        $translations = LangHasLibrary::find()
            ->select(['library_id', 'name'])
            ->where(['lang_id' => $languageId])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();
        $data = [];

        foreach ($translations as $translation) {
            $data[$translation['library_id']] = $translation['name'];
        }

        return $data;
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function fileUpload($id) {

        $path = Yii::getAlias("@common/web/uploads/doctors");
        $new_path1 = Yii::getAlias("@common/web/uploads/doctors/254-223");

        BaseFileHelper::createDirectory($path);
        BaseFileHelper::createDirectory($new_path1);

        $model = $this->findModel($id);
        $file = UploadedFile::getInstance($model, 'image');

        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
        $filename = substr(str_shuffle($symbols), 0, 16);

        $name ='doctor911-'. $filename . '.' . $file->extension;
        $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

        $image = $path .DIRECTORY_SEPARATOR .$name;

        $model->image = $name;
        $model->save();

        $new_name1 = $new_path1 .DIRECTORY_SEPARATOR.$name;
        copy($image, $new_name1);
//        $image = new ImageResize($image);
//        $image->resizeToBestFit(254, 223);
//        $image->crop(254, 223);
//        $image->save($new_name1);
    }
}
