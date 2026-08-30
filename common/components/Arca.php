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


        $username = getenv('ARCA_USERNAME') ?: '';
        $password = getenv('ARCA_PASSWORD') ?: '';
        if ($username === '' || $password === '') {
            return [false, 'Payment gateway credentials are not configured.'];
        }

        $PostFields = http_build_query([
            'currency' => Arca::CURRENCY,
            'amount' => $price,
            'language' => Arca::LANGUAGE,
            'orderNumber' => $pk,
            'password' => $password,
            'userName' => $username,
            'description' => Arca::DESCRIPTION,
            'pageView' => Arca::VIEW,
            'returnUrl' => $redirect_url,
        ], '', '&', PHP_QUERY_RFC3986);

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
        curl_setopt($CH, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($CH, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($CH, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($CH, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($CH, CURLOPT_TIMEOUT, 30);
        curl_setopt($CH, CURLOPT_POST, true);
        curl_setopt($CH, CURLOPT_POSTFIELDS, $PostFields);
        if (defined('CURLOPT_PROTOCOLS') && defined('CURLPROTO_HTTPS')) {
            curl_setopt($CH, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        }

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
