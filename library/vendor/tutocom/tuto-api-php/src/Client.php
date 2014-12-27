<?php

namespace Tuto;

require_once 'Exceptions.php';

class Client
{

    const API_VERSION = '0.2';

    /**
     *
     * @var string 
     */
    private $apiKey = null;

    /**
     *
     * @var string 
     */
    private $apiSecret = null;

    /**
     *
     * @var string 
     */
    private $apiUsername = null;

    /**
     *
     * @var Contributor
     */
    public $contributor;

    /**
     *
     * @var string 
     */
    public $root;

    /**
     *
     * @var array 
     */
    public static $errorsMap = array(
        'InvalidAPIKey' => 'Tuto_Invalid_API_Key',
        'InvalidCredentials' => 'Tuto_Invalid_Credentials',
        'NotAContributor' => 'Tuto_Not_A_Contributor',
        'UnsupportedProtocol' => 'Tuto_Unsupported_Protocol',
        'UnauthorizedAPIKey' => 'Tuto_Unauthorized_API_Key',
        'UnknownMethod' => 'Tuto_Unknown_Method',
        'LimitReached' => 'Tuto_Limit_Reached',
        'NotAuthorized' => 'Tuto_Not_Authorized',
        'IPDenied' => 'Tuto_IP_Denied',
        'IPNotAuthorized' => 'Tuto_IP_Not_Authorized'
    );

    public function __construct($apiKey = '')
    {
        if(!isset($apiKey) || empty($apiKey))
        {
            throw new Tuto\Tuto_ApiKey_Not_Found("You must provide an api key to use Tuto API");
        }
        $this->apiKey = $apiKey;
        $this->contributor = new Object\Contributor($this);

        $this->root = 'https://api.tuto.com/' . self::API_VERSION . '/';
    }

    /**
     * 
     * @param string $username
     * @param string $secret
     */
    public function setCredentials($username, $secret)
    {
        $this->apiUsername = $username;
        $this->apiSecret = $secret;
    }

    /**
     * 
     * @param string $method
     * @param string $url
     * @param string $params
     * @return mixed
     */
    public function call($method, $url, $params)
    {
        $guzzle = new \GuzzleHttp\Client(array(
            'base_url' => $this->root,
            'defaults' => array(
                'headers' => array(
                    'X-API-KEY' => $this->apiKey,
                    'User-Agent' => 'TutoPHP/' . self::API_VERSION
                )
            )
        ));


        if(isset($this->apiUsername) && !empty($this->apiUsername) &&
                isset($this->apiSecret) && !empty($this->apiSecret))
        {
            $_params = array_merge($params,
                    array(
                'auth' => array(
                    $this->apiUsername,
                    $this->apiSecret,
                    'digest'
                )
            ));
        }
        else
        {
            $_params = $params;
        }


        try
        {
            switch($method)
            {
                case 'get':
                    $this->response = $guzzle->get($url, $_params);
                    break;
                case 'post':
                    $this->response = $guzzle->post($url, $_params);
                    break;
            }
        }
        catch(\GuzzleHttp\Exception\ClientException $ex)
        {
            $this->response = $ex->getResponse();
            $json = $ex->getResponse()->json();

            if(!isset($json['error']))
            {
                throw new Tuto\Tuto_Error('We were unable to decode the JSON response from the Tuto API: ' . $json);
            }
            else
            {
                throw $this->castError($json);
            }


            return $json;
        }

        return $this->response->json();
    }

    private function castError($result)
    {
        if($result['error'] == 'error')
        {
            throw new Tuto\Tuto_Error('We received an unexpected error: ' . json_encode($result));
        }

        $class = (isset(self::$errorsMap[$result['error']])) ? 'Tuto\\' . self::$errorsMap[$result['error']]
                    : 'Tuto\Tuto_Error';
        return new $class((isset($result['message']) ? $result['message'] : ''));
    }

    /**
     * 
     * @return \GuzzleHttp\Message\FutureResponse
     */
    public function getResponseRaw()
    {
        return $this->response;
    }

}
