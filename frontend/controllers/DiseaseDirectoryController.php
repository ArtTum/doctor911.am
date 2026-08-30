<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/16/2018
 * Time: 11:21 AM
 */

namespace frontend\controllers;


use common\components\Helper;
use common\models\Library;
use Yii;
use yii\web\NotFoundHttpException;

class DiseaseDirectoryController extends BaseController
{

    /**
     * @param $letter
     * @return string
     */
    public function actionIndex($letter)
    {

        $letter = ($letter == 'А') ? Yii::t('frontend', 'A') : $letter;

        $disease_directory = Library::find()
            ->select(['lang_has_library.name', 'library.alias'])
            ->joinWith(['langHasLibraries'])
            ->orderBy(['lang_has_library.name' => SORT_ASC])
            ->where(['like', 'lang_has_library.name', $letter.'%', false])
            ->asArray()
            ->groupBy('library.id')
            ->all();


        $abc_rus = [];

        foreach (range(chr(0xC0),chr(0xDF)) as $v){
            $abc_rus[iconv('CP1251','UTF-8',$v)] = iconv('CP1251','UTF-8',$v);
        }

        $abc_arm = ['Ա','Բ','Գ','Դ','Ե','Զ','Է','Ը','Թ', 'Ժ','Ի','Լ','Խ','Ծ','Կ','Հ','Ձ','Ղ','Ճ',
            'Մ','Յ','Ն','Շ','Ո','Չ','Պ','Ջ','Ռ','Ս','Վ','Տ','Ր','Ց','Ու','Փ','Ք', 'և','Օ','Ֆ'];

        return $this->render('index', [
            'abc_rus' => $abc_rus,
            'abc_arm' => $abc_arm,
            'letter' => $letter,
            'disease_directory' => $disease_directory,
        ]);
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDisease($alias){

        $disease = $this->findModel($alias);

        return $this->render('disease', [
            'disease' => $disease,
        ]);

    }

    /**
     * Finds the Doctor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $alias
     * @return Library the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alias)
    {
        if (($model = Library::findOne(['status' => 1, 'alias' => $alias])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('frontend', 'The requested page does not exist.'));
    }

}