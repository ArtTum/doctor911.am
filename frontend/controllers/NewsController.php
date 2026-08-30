<?php
/**
 * Created by PhpStorm.
 * User: artur999
 * Date: 10/16/2018
 * Time: 1:57 PM
 */

namespace frontend\controllers;

use common\models\News;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class NewsController extends BaseController
{

    /**
     * @return string
     */
    public function actionIndex(){

        $item = News::find();
        $query = $item;
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;
        $blogs = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'blogs' => $blogs,
            'pages' => $pages,
        ]);
    }


    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSingleNews($alias){

        $blog = $this->findModel($alias);

        return $this->render('single-news', [
            'blog' => $blog,
        ]);
    }

    /**
     * @param $alias
     * @return News|null
     * @throws NotFoundHttpException
     */
    protected function findModel($alias)
    {
        if (($model = News::findOne(['alias' => $alias])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('admin', 'The requested page does not exist.'));
    }

}