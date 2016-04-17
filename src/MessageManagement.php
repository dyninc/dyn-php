<?php

namespace Dyn;

use Dyn\MessageManagement\Api\Client as ApiClient;
use Dyn\MessageManagement\Api\Resource\Accounts;
use Dyn\MessageManagement\Api\Resource\Senders;
use Dyn\MessageManagement\Api\Resource\SuppressionList;
use Dyn\MessageManagement\Api\Resource\Recipients;
use Dyn\MessageManagement\Api\Resource\Reports;
use Dyn\MessageManagement\Mail\MailInterface;
use Zend\Http\Client as HttpClient;
use RuntimeException;
use InvalidArgumentException;
use DateTime;

class MessageManagement
{
    /**
     * The API client instance, used for all API communication
     *
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * The Zend HTTP Client instance or configuration
     *
     * @var array|Zend\Http\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var Accounts
     */
    protected $accounts;

    /**
     * @var Senders
     */
    protected $senders;

    /**
     * @var SuppressionList
     */
    protected $suppressionList;

    /**
     * @var Recipients
     */
    protected $recipients;

    /**
     * @var Reports
     */
    protected $reports;


    /**
     * @param string                 $apiKey
     * @param array|Zend\Http\Client $httpClient
     */
    public function __construct($apiKey, $httpClient = null)
    {
        $this->apiKey = $apiKey;

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
            $this->apiClient->setApiKey($this->apiKey);
        }

        return $this->apiClient;
    }

    /**
     * Send a mail
     *
     * @param  MailInterface $mail The mail object
     * @return boolean
     */
    public function send(MailInterface $mail)
    {
        $params = $mail->toApiParams();

        // Make sure all the required fields are present
        foreach (array('to', 'from', 'subject') as $requiredField) {
            if (empty($params[$requiredField])) {
                throw new RuntimeException(
                    "Unable to send email without a '$requiredField' field"
                );
            }
        }

        // Ensure we have either a text or HTML body
        if (empty($params['bodytext']) && empty($params['bodyhtml'])) {
            throw new RuntimeException(
                "Unable to send email without either a text or HTML body"
            );
        }

        $result = $this->getApiClient()->post('/send', $params);
        if ($result && $result->isOk()) {
            return true;
        }

        return false;
    }

    /**
     * Returns the accounts API resource instance, creating it if required.
     * Used for all account related API functionality.
     *
     * @return SuppressionList
     */
    public function accounts()
    {
        if ($this->accounts === null) {
            $apiClient = $this->getApiClient();

            $this->accounts = new Accounts($apiClient);
        }

        return $this->accounts;
    }

    /**
     * Returns the senders API resource instance, creating it if required.
     * Used for all sender related API functionality.
     *
     * @return Senders
     */
    public function senders()
    {
        if ($this->senders === null) {
            $apiClient = $this->getApiClient();

            $this->senders = new Senders($apiClient);
        }

        return $this->senders;
    }

    /**
     * Returns the suppression list API resource instance, creating it if
     * required. Used for all suppression list related API functionality.
     *
     * @return SuppressionList
     */
    public function suppressionList()
    {
        if ($this->suppressionList === null) {
            $apiClient = $this->getApiClient();

            $this->suppressionList = new SuppressionList($apiClient);
        }

        return $this->suppressionList;
    }

    /**
     * Returns the recipients API resource instance, creating it if
     * required. Used for all recipient related API functionality.
     *
     * @return Recipients
     */
    public function recipients()
    {
        if ($this->recipients === null) {
            $apiClient = $this->getApiClient();

            $this->recipients = new Recipients($apiClient);
        }

        return $this->recipients;
    }

    /**
     * Returns the reports API resource instance, creating it if required.
     * Used for all report related API functionality.
     *
     * @return Reports
     */
    public function reports()
    {
        if ($this->reports === null) {
            $apiClient = $this->getApiClient();

            $this->reports = new Reports($apiClient);
        }

        return $this->reports;
    }
}
