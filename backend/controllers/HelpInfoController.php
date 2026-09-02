<?php

namespace backend\controllers;

use common\controllers\AuthController;
use common\models\Lang;
use common\models\LangHasHelpInfo;
use Eventviva\ImageResize;
use kotchuprik\sortable\actions\Sorting;
use Yii;
use common\models\HelpInfo;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * HelpInfoController implements the CRUD actions for HelpInfo model.
 */
class HelpInfoController extends AuthController
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'sorting' => [
                'class' => Sorting::className(),
                'query' => HelpInfo::find(),
            ],
        ];
    }


    /**
     * Lists all HelpInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HelpInfo::find()->orderBy(['order' => SORT_ASC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new HelpInfo();
        $model_lang = new LangHasHelpInfo();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $upload = UploadedFile::getInstance($model, 'image');
        $model->image = '';

        if ($model->load($post) && $model->save()) {

            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }

            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/help-info']);
        }

        return $this->render('create', [
            'model' => $model,
            'lang'  => $lang,
            'model_lang' => $model_lang,
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_lang = new LangHasHelpInfo();
        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;

        if ($model->load($post)) {
            if (!empty($upload)) {
                $model->image = $upload->name;
            } else {
                $model->image = $lastImage;
            }
            $model->save();
            if (!empty($upload)) {
                $this->fileUpload($model->id);
            }

            $model_lang->remove($model->id);
            $model_lang->add($post, $lang, $model->id);
            return $this->redirect(['/help-info']);
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

        return $this->redirect(['/help-info']);
    }

    /**
     * Finds the HelpInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HelpInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HelpInfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function fileUpload($id) {

        $path = Yii::getAlias("@common/web/uploads/help-info");
        $new_path1 = Yii::getAlias("@common/web/uploads/help-info/262-146");

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
//        $image->resizeToBestFit(262, 146);
//        $image->crop(262, 146);
//        $image->save($new_name1);
    }
}
