<?php
namespace common\components;
use common\models\ComponentLamp;
use common\models\Item;
use common\models\Product;
use common\models\Setting;
use Yii;
use yii\base\Component;

class Session extends Component{

    /**
     * @param $post
     */
    public static function checkout($post){

        $session = Yii::$app->session;
        $session->get('checkout');
        $session->set('checkout', $post);
    }

    /**
     * @param $id
     */
    public static function history($id){

        $session = Yii::$app->session;
        $item = Yii::$app->session->get('history');
        $product = Item::findOne(['id' => $id, 'deleted' => 0]);
        if($session->isActive){

            $item[] = [
                'alias' => $product->alias,
                'path' => $product->images[0]->path,
                'id' => $product->id,
                'title' => $product->title,
                'price_daily' => $product->price_daily,
                'price_3_days' => $product->price_3_days,
                'price_weekly' => $product->price_weekly,
                'user_info' => $product->user,
                'category_title' => $product->category->title,
            ];
            Yii::$app->session->set('history', $item);

        }
    }

    /**
     * @return array
     */
    public static function historyList(){
        $arr = [];
        $items = array_reverse(Yii::$app->session->get('history') ?? []);
        $pageSize = Setting::findOne(4)->value;

        foreach ($items as $k => $item){
//            if($pageSize <= $k){
                $arr[$item['alias']] = [
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'alias' => $item['alias'],
                    'path' => $item['path'],
                    'price_daily' => $item['price_daily'],
                    'price_3_days' => $item['price_3_days'],
                    'price_weekly' => $item['price_weekly'],
                    'user_info' => $item['user_info'],
                    'category_title' => $item['category_title'],

                ];
            }
//        }

        return $arr;
    }

}