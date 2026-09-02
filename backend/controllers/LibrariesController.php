<?php

namespace backend\controllers;

use common\components\Helper;
use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasLibrary;
use Yii;
use common\models\Library;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * LibrariesController implements the CRUD actions for Library model.
 */
class LibrariesController extends AuthController
{
    /**
     * Lists all Library models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Library::find()->joinWith(['langHasLibraries'])->orderBy(['lang_has_library.name' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Library model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Library();
        $model_lang = new LangHasLibrary();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $model->name_alias = $post['lang']['name_1'] ?? null;

            if ($model->save()) {

                $model_lang->add($post, $lang, $model->id);
                return $this->redirect(['/libraries']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * Updates an existing Library model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasLibrary();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $model->name_alias = $model->alias ?: ($post['lang']['name_1'] ?? null);

            if ($model->save()) {

                $model_lang->remove($model->id);
                $model_lang->add($post, $lang, $model->id);
                return $this->redirect(['/libraries']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
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

        return $this->redirect(['/libraries']);
    }

    /**
     * Finds the Library model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Library the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Library::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
