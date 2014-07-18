<?php

namespace Dyn\TrafficManagement\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Dyn\TrafficManagement\Api\Response;
use Dyn\TrafficManagement\Zone;

class Client
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $token;

    /**
     * This property holds the most recent HTTP response sent by the API.
     * Can be useful when debugging issues.
     *
     * @var Zend\Http\Response
     */
    protected $lastHttpResponse;

    /**
     * This property holds the most recent API response. Can be useful when
     * debugging issues.
     *
     * @var Response
     */
    protected $lastResponse;


    /**
     * Constructor
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Getter for the HTTP client instance
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $config = array(
                'useragent' => 'Dyn PHP SDK v0.1',
                'maxredirects' => 5
            );

            // use curl if available
            if (extension_loaded('curl')) {
                 $config['adapter'] = 'Zend\Http\Client\Adapter\Curl';
            }

            $this->httpClient = new HttpClient(null, $config);
        }

        return $this->httpClient;
    }

    /**
     * Builds a request object for the given API path
     *
     * @param  string  $path
     * @return Zend\Http\Request
     */
    protected function buildRequest($path)
    {
        $request = new Request();
        $request->setUri('https://api2.dynect.net/REST'.$path);

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');

        if ($this->token) {
            $headers->addHeaderLine('Auth-Token', $this->token);
        }

        return $request;
    }

    /**
     * Setter for API token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Getter for API token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Removes the existing token
     *
     * @return void
     */
    public function clearToken()
    {
        $this->token = null;
    }

    /**
     * Perform an API request.
     *
     * Returns a Response object if the API HTTP request return a valid
     * response, false otherwise.
     *
     * @param  Request $request
     * @return Response|false
     */
    protected function apiRequest(Request $request)
    {
        $httpClient = $this->getHttpClient();

        // check session
        if ($this->token === null && substr($request->getUri()->getPath(), 0, 13) !== '/REST/Session') {
            throw new Exception\NotAuthenticatedException(
                'An API session must be established by calling ' .
                'Dyn\TrafficManagement::createSession() before making other API calls'
            );
        }

        $this->lastHttpResponse = $httpClient->dispatch($request);
        if ($this->lastHttpResponse->isSuccess()) {
            $json = json_decode($this->lastHttpResponse->getBody());
            if (!$json) {
                return false;
            }

            // parse response and store
            $this->lastResponse = Response::fromJson($json);

            return $this->lastResponse;
        }

        return false;
    }

    /**
     * Returns the last HTTP response received from the API
     *
     * @return Zend\Http\Response
     */
    public function getLastHttpResponse()
    {
        return $this->lastHttpResponse;
    }

    /**
     * Returns the last API response received
     *
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Perform a GET request to the API
     *
     * @param  string $path  API path (excluding the /REST part)
     * @param  array  $data  Optional array of GET parameters
     * @return Response|false
     */
    public function get($path, array $data = null)
    {
        $request = $this->buildRequest($path);

        $request->setMethod(Request::METHOD_GET);
        // if ($data) {
        //     var_dump($data);
        //     $request->setContent(json_encode($data));
        // }
        if ($data) {
            $request->getQuery()->fromArray($data);
        }

        return $this->apiRequest($request);
    }

    /**
     * Perform a POST request to the API
     *
     * @param  string $path  API path (excluding the /REST part)
     * @param  array  $data  Optional array of POST data
     * @return Response|false
     */
    public function post($path, array $data = null)
    {
        $request = $this->buildRequest($path);

        $request->setMethod(Request::METHOD_POST);
        if ($data) {
            $request->setContent(json_encode($data));
        }

        return $this->apiRequest($request);
    }

    /**
     * Perform a PUT request to the API
     *
     * @param  string $path  API path (excluding the /REST part)
     * @param  array  $data  Optional array of PUT data
     * @return Response|false
     */
    public function put($path, array $data = null)
    {
        $request = $this->buildRequest($path);

        $request->setMethod(Request::METHOD_PUT);
        if ($data) {
            $request->setContent(json_encode($data));
        }

        return $this->apiRequest($request);
    }

    /**
     * Perform a DELETE request to the API
     *
     * @param  string $path  API path (excluding the /REST part)
     * @return Response|false
     */
    public function delete($path)
    {
        $request = $this->buildRequest($path);

        $request->setMethod(Request::METHOD_DELETE);

        return $this->apiRequest($request);
    }
}
