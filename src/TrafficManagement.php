<?php

namespace Dyn;

use Dyn\TrafficManagement\Api\Client as ApiClient;
use Dyn\TrafficManagement\Zone;
use Zend\Http\Client as HttpClient;

class TrafficManagement
{
    /**
     * The API client instance, used for all API communication
     *
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * Customer name (for login)
     *
     * @var string
     */
    protected $customerName;

    /**
     * Username (for login)
     *
     * @var string
     */
    protected $username;

    /**
     * Password (for login)
     *
     * @var string
     */
    protected $password;

    /**
     * The Zend HTTP Client instance or configuration
     *
     * @var array|Zend\Http\Client
     */
    protected $httpClient;


    /**
     * @param string                 $customerName
     * @param string                 $username
     * @param string                 $password
     * @param array|Zend\Http\Client $httpClient
     */
    public function __construct($customerName, $username, $password, $httpClient = null)
    {
        $this->customerName = $customerName;
        $this->username = $username;
        $this->password = $password;

        if ($httpClient) {
            if (!is_array($httpClient) && !($httpClient instanceof HttpClient)) {
                throw new \RuntimeException('Invalid Http client parameter supplied');
            }

            $this->httpClient = $httpClient;
        }
    }

    /**
     * Setter for API client
     *
     * @param ApiClient $apiClient
     */
    public function setApiClient(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    /**
     * Returns an instance of the API client, creating it if required
     *
     * If a custom instance of the Zend Http Client was supplied to this class'
     * constructor it will be used. This allows for custom functionality (such as
     * working through a HTTP proxy) if needed.
     *
     * @return ApiClient
     */
    public function getApiClient()
    {
        if (!$this->apiClient) {
            $this->apiClient = new ApiClient($this->httpClient);
        }

        return $this->apiClient;
    }

    /**
     * Creates an API session using the existing credentials
     *
     * If successful, the API token is stored in the API client for use in future requests
     *
     * @return boolean
     */
    public function createSession()
    {
        $result = $this->getApiClient()->post(
            '/Session/',
            array(
                'customer_name' => $this->customerName,
                'user_name' => $this->username,
                'password' => $this->password
            )
        );

        if ($result && $result->isComplete()) {
            $token = $result->data->token;

            $this->getApiClient()->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Refresh the current session token, extending its expiry
     *
     * @return boolean
     */
    public function refreshSession()
    {
        $result = $this->getApiClient()->put(
            '/Session/',
            array(
                'token' => $this->getApiClient()->getToken()
            )
        );

        return ($result && $result->isComplete());
    }

    /**
     * Removes the API session and clears the token from the API client
     *
     * @return boolean
     */
    public function deleteSession()
    {
        $result = $this->getApiClient()->delete('/Session/');
        if ($result && $result->isComplete()) {
            $this->getApiClient()->clearToken();

            return true;
        }

        return false;
    }

    /**
     * Returns the specified zone, or false if it doesn't exist.
     *
     * @param  string $zoneName e.g. 'example.com'
     * @return Zone|false
     */
    public function getZone($zoneName)
    {
        $apiClient = $this->getApiClient();

        $result = $apiClient->get('/Zone/'.$zoneName);
        if ($result && $result->isComplete()) {
            $zone = new Zone($apiClient);
            $zone->setName($result->data->zone)
                 ->setType($result->data->zone_type)
                 ->setSerialStyle($result->data->serial_style)
                 ->setSerial($result->data->serial);

            return $zone;
        }

        return false;
    }

    /**
     * Returns an array of all zones from the account
     *
     * @return array|false
     */
    public function getZones()
    {
        $apiClient = $this->getApiClient();

        $result = $apiClient->get('/Zone/', array('detail' => 'y'));
        if ($result && $result->isComplete()) {
            $zones = array();

            if (count($result->data) > 0) {
                foreach ($result->data as $zoneData) {
                    $zone = new Zone($apiClient);
                    $zone->setName($zoneData->zone)
                         ->setType($zoneData->zone_type)
                         ->setSerialStyle($zoneData->serial_style)
                         ->setSerial($zoneData->serial);

                    $zones[] = $zone;
                }
            }

            return $zones;
        }

        return false;
    }

    /**
     * Create a new zone
     *
     * @param  string $zoneName    E.g. example.com
     * @param  string $rname       Email address contact for the zone
     * @param  integer $defaultTtl Default TTL (in seconds)
     * @param  string $serialStyle
     * @return Zone|false|Dyn\TrafficManagement\Api\Response
     */
    public function createZone($zoneName, $rname, $defaultTtl, $serialStyle = 'increment')
    {
        $zone = new Zone($this->getApiClient());
        $zone->setName($zoneName)
             ->setRname($rname)
             ->setDefaultTtl($defaultTtl)
             ->setSerialStyle($serialStyle);

        $params = array(
            'rname' => $rname,
            'ttl' => $defaultTtl,
            'serial_style' => $serialStyle
        );

        $result = $this->apiClient->post('/Zone/'.$zoneName, $params);
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return $zone;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Delete the specified zone
     *
     * @param  Zone $zone
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function deleteZone($zone)
    {
        $result = $this->apiClient->delete('/Zone/'.$zone->getName());

        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }
}
