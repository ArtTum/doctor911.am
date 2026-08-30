<?php

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasMenu;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends AuthController
{

    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => Menu::find(),
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find()->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model_lang = new LangHasMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/menu']);
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/menu']);
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

        return $this->redirect(['/menu']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
