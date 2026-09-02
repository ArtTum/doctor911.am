<?php

namespace backend\controllers;

use common\components\Helper;
use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasPage;
use Yii;
use common\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends AuthController
{
    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $model_lang = new LangHasPage();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = $post['lang']['name_1'] ?? null;

        if ($model->load($post) && $model->save()) {

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/pages']);
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasPage();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = !empty($post['Page']['alias'])
            ? $post['Page']['alias']
            : ($post['lang']['name_1'] ?? null);

        if ($model->load($post) && $model->save()) {

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/pages']);
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

        return $this->redirect(['/pages']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
