<?php

namespace Dyn\Api;

use Zend\Http\Client as HttpClient;

abstract class BaseClient
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

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
     * The configuration used to configure the HTTP client (excluding the
     * adapter, which is calculated at run time)
     *
     * @var array
     */
    protected $httpClientConfig = array(
        'useragent' => 'Dyn PHP SDK v0.5.0',
        'maxredirects' => 5
    );


    /**
     * Constructor
     *
     * @param array|HttpClient $httpClient
     */
    public function __construct($httpClient = null)
    {
        if ($httpClient) {
            if ($httpClient instanceof HttpClient) {
                // use the supplied instance
                $this->httpClient = $httpClient;

            } elseif (is_array($httpClient)) {
                // merge the user-supplied HTTP configuration with the default
                $this->httpClientConfig = array_merge(
                    $this->httpClientConfig, $httpClient
                );
            }
        }
    }

    /**
     * Returns the configuration to be used to configure the HTTP client.
     * It will also calculate whether or not the curl adapter can be used, if
     * another adapter has not already been specified.
     *
     * @return array
     */
    public function getHttpClientConfig()
    {
        if (!array_key_exists('adapter', $this->httpClientConfig)) {
            // use curl if available
            if (extension_loaded('curl')) {
                 $this->httpClientConfig['adapter'] = 'Zend\Http\Client\Adapter\Curl';
            }
        }

        return $this->httpClientConfig;
    }

    /**
     * Getter for the HTTP client instance
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient(null, $this->getHttpClientConfig());
        }

        return $this->httpClient;
    }
}
