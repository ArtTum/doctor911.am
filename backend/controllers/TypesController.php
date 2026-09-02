<?php

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasType;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\Type;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * TypesController implements the CRUD actions for Type model.
 */
class TypesController extends AuthController
{


    /**
     * Lists all Type models.
     * @return mixed
     */

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Type::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Type model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Type();
        $model_lang = new LangHasType();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = $post['lang']['name_1'] ?? null;

        if ($model->load($post) && $model->save()) {

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/types']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
            ]);
        }
    }


    /**
     * Updates an existing Type model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasType();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/types']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
            ]);
        }
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/types']);
    }

    /**
     * Finds the Type model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Type the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Type::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }
}
