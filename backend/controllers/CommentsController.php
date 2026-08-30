<?php

namespace backend\controllers;

use common\components\Translate;
use common\controllers\AuthController;
use common\models\Doctor;
use common\models\Hospital;
use Yii;
use common\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * CommentsController implements the CRUD actions for Comment model.
 */
class CommentsController extends AuthController
{

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();
        $dta_hospital = [];
        $dta_doctor = [];

        $hospitals = Hospital::findAll(['status' => 1]);
        $doctors = Doctor::findAll(['status' => 1]);

        foreach ($hospitals as $hospital){
            $dta_hospital[$hospital->id] = Translate::text($hospital->getLangHasHospitals(), 'name');
        }

        foreach ($doctors as $doctor){
            $dta_doctor[$doctor->id] = Translate::text($doctor->getLangHasDoctors(), 'full_name');
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/comments']);
        }

        return $this->render('create', [
            'model' => $model,
            'dta_hospital' => $dta_hospital,
            'dta_doctor' => $dta_doctor,
        ]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dta_hospital = [];
        $dta_doctor = [];

        $hospitals = Hospital::findAll(['status' => 1]);
        $doctors = Doctor::findAll(['status' => 1]);

        foreach ($hospitals as $hospital){
            $dta_hospital[$hospital->id] = Translate::text($hospital->getLangHasHospitals(), 'name');
        }

        foreach ($doctors as $doctor){
            $dta_doctor[$doctor->id] = Translate::text($doctor->getLangHasDoctors(), 'full_name');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/comments']);
        }

        return $this->render('update', [
            'model' => $model,
            'dta_hospital' => $dta_hospital,
            'dta_doctor' => $dta_doctor,
        ]);
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

        return $this->redirect(['/comments']);
    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
