<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 4/8/2017
 * Time: 10:31 PM
 */
namespace common\components;

Class Arca{

    const CURRENCY = '051';
    const LANGUAGE = 'en';
    const PASSWORD = 'rentalltrans1234_api';
    const USERNAME = '34538912_api';
    const DESCRIPTION = 'rentalltrans.com';
    const VIEW = 'DESKTOP';
    const RETURN_URL = 'http://rentalltrans.com/payment/arca-payment-done';

    /**
     * @return Arca
     */
    public static function factory(){
        return new Arca();
    }


    /**
     * @param $pk
     * @param $price
     * @return array|null
     */
    public function get_form2($pk, $price, $redirect_url){

        if(!$pk && !$price){
            return null;
        }


        $PostFields = 'currency='.Arca::CURRENCY.'&';
        $PostFields .= 'amount='.$price.'&';
        $PostFields .= 'language='.Arca::LANGUAGE.'&';
        $PostFields .= 'orderNumber='.$pk.'&';
        $PostFields .= 'password='.Arca::PASSWORD.'&';
        $PostFields .= 'userName='.Arca::USERNAME.'&';
        $PostFields .= 'description='.Arca::DESCRIPTION.'&';
        $PostFields .= 'pageView='.Arca::VIEW.'&';
        $PostFields .= 'returnUrl='.$redirect_url.'&';
        //   $PostFields .= 'jsonParams='.Arca::RETURN_URL;

        $CURL_Request = $this->Send_CURL_Request('https://ipay.arca.am/payment/rest/register.do', $PostFields);

        return  $CURL_Request ;

    }

    /**
     * @param $URL
     * @param $PostFields
     * @return array
     */
    public function Send_CURL_Request($URL, $PostFields)
    {

        $CH = curl_init();
        $error = array();
        if ($CH === false)
        {
            $error = 'Initialization error #'.curl_errno($CH).' ---- '.curl_error($CH);
        }

        curl_setopt($CH, CURLOPT_URL,  $URL);
        curl_setopt($CH, CURLOPT_HEADER, false);
        curl_setopt($CH, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($CH, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($CH, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CH, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($CH, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($CH, CURLOPT_SSLVERSION, 1);
        curl_setopt($CH, CURLOPT_TIMEOUT, 30);
        curl_setopt($CH, CURLOPT_POST, true);
        curl_setopt($CH, CURLOPT_POSTFIELDS, $PostFields);

        $Result = curl_exec($CH);
        $CURL_Error = curl_errno($CH);
        if ($CURL_Error > 0)
        {
            $error = 'cURL Error: --'.$CURL_Error.'--<br>';
            $RetStr = false;
        }
        else
        {
            $RetStr = $Result;
        }
        curl_close($CH);

        return array($RetStr, $error);
    }
}