<?php

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasFooterMenu;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\FooterMenu;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * FooterMenuController implements the CRUD actions for FooterMenu model.
 */
class FooterMenuController extends AuthController
{

    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => FooterMenu::find(),
            ],
        ];
    }

    /**
     * Lists all FooterMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FooterMenu::find()->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new FooterMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FooterMenu();
        $model_lang = new LangHasFooterMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/footer-menu']);
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * Updates an existing FooterMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasFooterMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/footer-menu']);
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

        return $this->redirect(['/footer-menu']);
    }

    /**
     * Finds the FooterMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FooterMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FooterMenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
