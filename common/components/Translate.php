<?php

namespace common\components;

use common\models\Lang;
use yii\base\Component;

class Translate extends Component{
    private static $languageIds = [];

    /**
     * Маска начала и конца
     */

    const AVIOR_MARK = ':escape[:end:lang:escape]';

    /**
     * Перевод текста на требуемый язые
     * по умолчанию если не указать на каком языке нужно вывести текст
     * то он будет выведён на основном языке сайта, идентификатор которого находится в
     * переменной I18n::$lang
     * @param $model
     * @param $param
     * @param null $lang
     * @return string
     */

    public static function text($model, $param, $lang = NULL){

        if($lang == NULL){
            $lang = \Yii::$app->language;
        }

        if (!array_key_exists($lang, self::$languageIds)) {
            $languageId = Lang::find()->select('id')->where(['iso' => $lang])->scalar();
            self::$languageIds[$lang] = $languageId === false ? null : (int) $languageId;
        }

        if (self::$languageIds[$lang] === null) {
            return '';
        }

        $translation = $model->andWhere(['lang_id' => self::$languageIds[$lang]])->one();

        return $translation[$param] ?? '';
    }
    

    /**
     * Устонавливает начальный и конечный маркер
     * находящийся в Translate::AVIOR_MARK
     * для входящего текста
     * @param $lang
     * @param bool $end
     * @return mixed
     */
    protected static function mark($lang, $end = false){

        return ($end) ? str_replace(':escape','\\',str_replace(':end','\/',str_replace(':lang',$lang,Translate::AVIOR_MARK))) : str_replace(':escape','',str_replace(':escape','\\',str_replace(':end','',str_replace(':lang',$lang,Translate::AVIOR_MARK)))) ;
    }

    /**
     * Устонавливает начальный и конечный маркер
     * находящийся в Translate::AVIOR_MARK
     * для выходящего текста
     * @param $lang
     * @param bool $end
     * @return mixed
     */
    protected static function mark_output($lang, $end = false){

        return ($end) ? str_replace(':escape','',str_replace(':end','/',str_replace(':lang',$lang,Translate::AVIOR_MARK))) : str_replace(':escape','',str_replace(':end','',str_replace(':lang',$lang,Translate::AVIOR_MARK))) ;
    }

    /**
     * Обрамляет текст в соответствующие теги
     * для указанного языка
     * @param $lang
     * @param $text
     * @return string
     */
    protected static function set_lang($lang, $text){

        return Translate::mark_output($lang).$text.Translate::mark_output($lang,true);
    }

    public static function mark_array( array $array, $languages){
        //выходной массив
        $output = [];
        //обработанные ключи
        $processed = [];
        $tmp_data = '';
        $arr = [];
        $langs_iso = Lang::find()->all();
        foreach($langs_iso as $item){
            $arr[] = $item->iso;
        }
        $langs = implode("|", $arr);

        //текущий ключ массива
        $translateble_key = '';

        //перебор ключей входящего массива
        foreach($array as $key => $value){
            if(array_key_exists($key,$processed)) continue;
            //проверяем если ключ похож на переводимый
            if(preg_match('~[_]('.$langs.')$~',$key)){
                $translateble_key = preg_replace('~[_]('.$langs.')$~','',$key);

                //перебор языков
                foreach($languages as $lang){

                    $processed[$translateble_key.'_'.$lang->iso] = true;

                    if(!empty($array[$translateble_key.'_'.$lang->iso])){
                        $tmp_data .= self::set_lang($lang->iso,$array[$translateble_key.'_'.$lang->iso]);

                    }
                }

                $output[$translateble_key] = $tmp_data;
            }else{
                $output[$key] = $value;
            }



            $tmp_data = $translateble_key = '';
        }

        return $output;
    }

    /**
     * @param array|null $array
     */
    public static function from_array(array $array = null){

        $output = array();

        foreach($array as $key => $val){
            echo 1;
        }
    }

    /**
     * Возвращает переводимый ключ (например для инпутов исходный ключ title выходной title_ru)
     * @param $key
     * @param $lang
     * @return string
     */
    public static function translatable_key($key,$lang){

        return $key.'_'.$lang;
    }
}
