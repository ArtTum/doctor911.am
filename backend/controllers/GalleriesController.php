<?php

namespace backend\controllers;

use common\components\Translate;
use common\controllers\AuthController;
use common\models\Doctor;
use Eventviva\ImageResize;
use Yii;
use common\models\Galery;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * GalleriesController implements the CRUD actions for Galery model.
 */
class GalleriesController extends AuthController
{

    /**
     * Lists all Galery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Galery::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Galery();
        $upload = UploadedFile::getInstance($model, 'path');

        $post = Yii::$app->request->post();
        $plastic_surgeon = [];

        $doctors_p = Doctor::find()
            ->where(['plastic_surgeon' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        foreach ($doctors_p as $item){
            $plastic_surgeon[$item->id] = Translate::text($item->getLangHasDoctors(), 'full_name');
        }
        $model->path = '/images/fa-camera.png';

        if ($model->load($post) && $model->save()) {



            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->doctor_id);
            }

            return $this->redirect(['/galleries']);
        }

        return $this->render('create', [
            'model' => $model,
            'plastic_surgeon' => $plastic_surgeon,
        ]);
    }


    /**
     * @param $id
     * @param $doctor_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id, $doctor_id)
    {
        $model = $this->findModel($id, $doctor_id);
        $upload = UploadedFile::getInstance($model, 'path');
        $post = Yii::$app->request->post();
        $lastImage = $model->path;
        $plastic_surgeon = [];
        $doctors_p = Doctor::find()
            ->where(['plastic_surgeon' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        foreach ($doctors_p as $item){
            $plastic_surgeon[$item->id] = Translate::text($item->getLangHasDoctors(), 'full_name');
        }


        if ($model->load($post)) {

            if (!empty($upload)) {
                $model->path = $upload->name;
            } else {
                $model->path = $lastImage;
            }
            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id, $model->doctor_id);
            }
            return $this->redirect(['/galleries']);
        }

        return $this->render('update', [
            'model' => $model,
            'plastic_surgeon' => $plastic_surgeon,
        ]);
    }


    /**
     * @param $id
     * @param $doctor_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $doctor_id)
    {
        $this->findModel($id, $doctor_id)->delete();

        return $this->redirect(['/galleries']);
    }

    /**
     * Finds the Galery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $doctor_id
     * @return Galery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $doctor_id)
    {
        if (($model = Galery::findOne(['id' => $id, 'doctor_id' => $doctor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

    /**
     * @param $id
     * @param $doctor_id
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function fileUpload($id, $doctor_id) {

        $path = Yii::getAlias("@common/web/uploads/galleries");


        BaseFileHelper::createDirectory($path);

        $model = $this->findModel($id, $doctor_id);
        $file = UploadedFile::getInstance($model, 'path');

        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
        $filename = substr(str_shuffle($symbols), 0, 16);

        $name ='doctor911-'. $filename . '.' . $file->extension;
        $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

        $model->path = '/uploads/galleries/'.$name;
        $model->save();


    }
}
