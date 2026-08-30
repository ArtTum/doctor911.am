<?php

namespace backend\controllers;

use common\components\Helper;
use common\components\Translate;
use common\controllers\AuthController;
use common\models\HospitalHasType;
use common\models\Lang;
use common\models\LangHasHospital;
use common\models\Type;
use Eventviva\ImageResize;
use Yii;
use common\models\Hospital;
use yii\data\ActiveDataProvider;
use yii\helpers\BaseFileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * HospitalsController implements the CRUD actions for Hospital model.
 */
class HospitalsController extends AuthController
{


    /**
     * Lists all Hospital models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Hospital::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Eventviva\ImageResizeException
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Hospital();
        $model_lang = new LangHasHospital();
        $model_type = new HospitalHasType();

        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = $post['lang']['name_1'];
        $upload = UploadedFile::getInstance($model, 'image');



        $type_data = [];
        $types = Type::findAll(['status' => 1]);

        foreach ($types as $type){
            $type_data[$type->id] = Translate::text($type->getLangHasTypes(), 'name');
        }
        $model->image = 'name';

        if ($model->load($post) && $model->save()) {

            if (!empty($upload)) {

                $this->fileUpload($model->id);
            }

            $model_lang->add($post, $lang, $model->id);
            $model_type->add($post["HospitalHasType"]['type_id'], $model->id);

            return $this->redirect(['/hospitals']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
                'model_type' => $model_type,
                'type_data' => $type_data,
            ]);
        }
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
        $model_lang = new LangHasHospital();
        $model_type = new HospitalHasType();

        $lang = Lang::find()->all();
        $post = Yii::$app->request->post();
        $model->name_alias = $post['Hospital']['alias'] ? $post['Hospital']['alias'] : $post['lang']['name_1'];
        $upload = UploadedFile::getInstance($model, 'image');
        $lastImage = $model->image;

        $type_data = [];
        $types = Type::findAll(['status' => 1]);

        foreach ($types as $type){
            $type_data[$type->id] = Translate::text($type->getLangHasTypes(), 'name');
        }

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

            $model_type->remove($model->id);
            $model_type->add($post["HospitalHasType"]['type_id'], $model->id);

            return $this->redirect(['/hospitals']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'lang'  => $lang,
                'model_lang' => $model_lang,
                'model_type' => $model_type,
                'type_data' => $type_data,
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

        return $this->redirect(['/hospitals']);
    }

    /**
     * Finds the Hospital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hospital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hospital::findOne($id)) !== null) {
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

        $path = Yii::getAlias("@common/web/uploads/hospitals");
        $new_path1 = Yii::getAlias("@common/web/uploads/hospitals/254-223");

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
        $file->saveAs($new_path1 . DIRECTORY_SEPARATOR . $new_name1);

//        $image = new ImageResize($image);
//        $image->resizeToBestFit(254, 223);
//        $image->crop(254, 223);
//        $image->save($new_name1);
    }
}
