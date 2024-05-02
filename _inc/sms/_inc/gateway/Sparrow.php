<?php

namespace SMSGateway\Gateway;

class Sparrow implements GatewayInterface
{
    protected $defaultConfig = array(
        'token'    => '',
        'identity'    => '',
        'url' => 'http://api.sparrowsms.com/v2/sms/',
    );

    protected $token;
    protected $identity;
    protected $url;

    public function __construct ($config = array()) 
    {
        extract(mergeArray($this->defaultConfig, $config));
        $this->token = $token;
        $this->identity = $identity;
        $this->url =  $url;
    }

    public function send($to, $message) 
    {

        $args = http_build_query(array(
           'token' => $this->token,
           'from'  => $this->identity,
           'to'    => $to,
           'text'  => $message,
       ));

       $url = $this->url;

       # Make the call using API.
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

       // Response
       $response = curl_exec($ch);
       $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       if ($err = curl_errno($ch)) {
            curl_close($ch);
            return "cURL Error #:" . $err;
        } else {
            curl_close($ch);
            return $status_code;
        }
    }
}