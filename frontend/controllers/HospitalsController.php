<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 9/18/2018
 * Time: 2:04 PM
 */

namespace frontend\controllers;

use common\models\Comment;
use common\models\Hospital;
use common\models\Type;
use Yii;
use yii\web\NotFoundHttpException;

class HospitalsController extends BaseController
{


    /**
     * @param $type
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($type){

        $types = $this->findModelType($type);

        $hospitals = Hospital::find()
            ->leftJoin('hospital_has_type', 'hospital_has_type.hospital_id=hospital.id')
            ->where(['hospital.status' => 1])
            ->andWhere(['hospital_has_type.type_id' => $types->id])
            ->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'hospitals' => $hospitals,
            'types' => $types,
        ]);

    }


    /**
     * @param $type
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionHospital($type, $alias){

        $model = new Comment();
        $hospital = $this->findModel($alias);
        $types = $this->findModelType($type);

        $comments = Comment::find()
            ->where(['status' => 1])
            ->andWhere(['hospital_id' => $hospital->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $model->hospital_id = $hospital->id;
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {

            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for leaving comment'));

            return $this->redirect(['/'.$types->alias.'/'. $hospital->alias]);
        }

        return $this->render('hospital', [
            'model' => $model,
            'hospital' => $hospital,
            'types' => $types,
            'comments' => $comments,
        ]);
    }

    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $alias
     * @return Hospital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Hospital::findOne(['status' => 1, 'alias' => $alias])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
    }

    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $alias
     * @return Type the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelType($alias)
    {
        if (($model = Type::findOne(['status' => 1, 'alias' => $alias])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
    }

}