<?php

namespace App\Traits;

trait ApiMethods
{
    public function getContents($input = 'php://input')
    {
        /**
         * Make sure that directive init_get('allow_url_fopen') is enable in php.ini
         * allow_url_fopen = on
         */
        ini_set("allow_url_fopen", true);
        $input = json_decode(file_get_contents($input), true);
        
        return $input;
    }

    public function getJsonRequestKey($key, $filterOption = FILTER_SANITIZE_STRING)
    {
        if ($this->getContents()) {
            $requestObj = filter_var_array($this->getContents(), $filterOption);

            return isset($requestObj[$key]) ? $requestObj[$key] : false;
        }
    }

    public function isGetParam($key)
    {
        if (!isset($_GET[$key])) return false;

        return filter_var($_GET[$key], FILTER_SANITIZE_STRING);
    }

    public function curlPostForm($sendData)
    {
        $cUrl = curl_init();
        curl_setopt($cUrl, CURLOPT_URL, "https://www2.correios.com.br/sistemas/rastreamento/resultado_semcontent.cfm");

        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cUrl, CURLOPT_POSTFIELDS, http_build_query($sendData));
        $output = curl_exec($cUrl);
        curl_close($cUrl);

        return $output;
    }
}
