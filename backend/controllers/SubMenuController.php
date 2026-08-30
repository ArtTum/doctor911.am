<?php

namespace backend\controllers;

use common\components\Helper;
use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasSubMenu;
use common\models\Menu;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\SubMenu;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * SubMenuController implements the CRUD actions for SubMenu model.
 */
class SubMenuController extends AuthController
{

    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => SubMenu::find()->where(['menu_id' => Yii::$app->request->get('id')]),
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $menu = $this->findModelMenu($id);

        $dataProvider = new ActiveDataProvider([
            'query' => SubMenu::find()->where(['menu_id' => $menu->id])->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'menu' => $menu
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        $model = new SubMenu();
        $menu = $this->findModelMenu($id);

        $model->menu_id = $menu->id;
        $model_lang = new LangHasSubMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/sub-menu/'.$menu->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * Updates an existing SubMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $menu_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $menu_id)
    {

        $model = $this->findModel($id, $menu_id);
        $model_lang = new LangHasSubMenu();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);

            return $this->redirect(['/sub-menu/'.$model->menu_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }

    /**
     * @param $id
     * @param $menu_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $menu_id)
    {
        $this->findModel($id, $menu_id)->delete();

        return $this->redirect(['/sub-menu/'.$menu_id]);
    }

    /**
     * Finds the SubMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $menu_id
     * @return SubMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $menu_id)
    {
        if (($model = SubMenu::findOne(['id' => $id, 'menu_id' => $menu_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

    /**
     * Finds the SubMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelMenu($id)
    {
        if (($model = Menu::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
