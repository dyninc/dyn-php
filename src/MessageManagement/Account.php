<?php

namespace Dyn\MessageManagement;

use InvalidArgumentException;
use DateTime;

class Account
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $accountName;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $zipCode;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $userType;

    /**
     * @var DateTime
     */
    protected $created;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $timeZone;

    /**
     * Boucne callback URL
     *
     * @var string
     */
    protected $bounceUrl;

    /**
     * Spam complaint callback URL
     *
     * @var string
     */
    protected $spamUrl;

    /**
     * Unsubscribe callback URL
     *
     * @var string
     */
    protected $unsubscribeUrl;

    /**
     * @var boolean
     */
    protected $trackLinks;

    /**
     * @var boolean
     */
    protected $trackOpens;

    /**
     * @var string
     */
    protected $testMode;

    /**
     * @var boolean
     */
    protected $trackUnsubscribes;

    /**
     * @var integer
     */
    protected $maxSampleCount;

    /**
     * @var string
     */
    protected $contactName;

    /**
     * @var integer
     */
    protected $emailsSent;


    /**
     * Creates an Account instance from the supplied JSON data
     *
     * @param stdClass $json
     * @return self
     */
    public static function fromJson($json)
    {
        $account = new static();
        $account->setUsername($json->username)
                ->setCompanyName($json->companyname)
                ->setAddress($json->address)
                ->setCity($json->city)
                ->setState($json->state)
                ->setCountry($json->country)
                ->setZipCode($json->zipcode)
                ->setPhone($json->phone)
                ->setUserType($json->usertype)
                ->setCreated($json->created)
                ->setApiKey($json->apikey)
                ->setTimeZone($json->timezone)
                ->setTrackLinks($json->tracklinks)
                ->setTrackOpens($json->trackopens)
                ->setTestMode($json->testmode)
                ->setTrackUnsubscribes($json->trackunsubscribes)
                ->setContactName($json->contactname)
                ->setEmailsSent($json->emailssent);

        if (isset($json->bounceurl)) {
            $account->setBounceUrl($json->bounceurl);
        }

        if (isset($json->spamurl)) {
            $account->setSpamUrl($json->spamurl);
        }

        if (isset($json->unsuburl)) {
            $account->setUnsubscribeUrl($json->unsuburl);
        }

        if (isset($json->accountname)) {
            $account->setAccountName($json->accountname);
        }

        if (isset($json->max_sample_count)) {
            $account->setMaxSampleCount($json->max_sample_count);
        }

        return $account;
    }

    /**
     * Returns an array of account properties suitable for use in various
     * API calls.
     *
     * @return array
     */
    public function toApiParams()
    {
        return array(
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'companyname' => $this->getCompanyName(),
            'phone' => $this->getPhone(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'zipcode' => $this->getZipCode(),
            'country' => $this->getCountry(),
            'timezone' => $this->getTimeZone(),
            'bounceurl' => $this->getBounceUrl(),
            'spamurl' => $this->getSpamUrl(),
            'unsubscribeurl' => $this->getUnsubscribeUrl(),
            'trackopens' => $this->getTrackOpens() ? '1' : '0',
            'tracklinks' => $this->getTrackLinks() ? '1' : '0',
            'trackunsubscribes' => $this->getTrackUnsubscribes() ? '1' : '0',
            'generatenewapikey' => '0', // TODO
        );
    }

    /**
     * Setter for username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid username specified');
        }

        $this->username = $username;

        return $this;
    }

    /**
     * Getter for username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Setter for password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Getter for password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Setter for account name
     *
     * @param string $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Getter for account name
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Setter for company name
     *
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Getter for company name
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Setter for address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Getter for address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Setter for city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Getter for city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Setter for state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Getter for state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Setter for country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Getter for country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Setter for zip code
     *
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Getter for zip code
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Setter for phone number
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Getter for phone number
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Setter for user type
     *
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Getter for user type
     *
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Setter for created date
     *
     * Converts the date to a PHP DateTime object if required
     *
     * @param DateTime|string $created
     */
    public function setCreated($created)
    {
        if (!($created instanceof DateTime)) {
            $created = new DateTime($created);
        }

        $this->created = $created;

        return $this;
    }

    /**
     * Getter for created date
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Setter for API key
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Getter for API key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Setter for time zone
     *
     * @param string $timeZone
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Getter for time zone
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Setter for bounce URL
     *
     * @param string $bounceUrl
     */
    public function setBounceUrl($bounceUrl)
    {
        $this->bounceUrl = $bounceUrl;

        return $this;
    }

    /**
     * Getter for bounce URL
     *
     * @return string
     */
    public function getBounceUrl()
    {
        return $this->bounceUrl;
    }

    /**
     * Setter for spam URL
     *
     * @param string $spamUrl
     */
    public function setSpamUrl($spamUrl)
    {
        $this->spamUrl = $spamUrl;

        return $this;
    }

    /**
     * Getter for spam URL
     *
     * @return string
     */
    public function getSpamUrl()
    {
        return $this->spamUrl;
    }

    /**
     * Setter for unsubscribe URL
     *
     * @param string $unsubscribeUrl
     */
    public function setUnsubscribeUrl($unsubscribeUrl)
    {
        $this->unsubscribeUrl = $unsubscribeUrl;

        return $this;
    }

    /**
     * Getter for unsubscribe URL
     *
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        return $this->unsubscribeUrl;
    }

    /**
     * Setter for track links
     *
     * @param boolean|string $trackLinks
     */
    public function setTrackLinks($trackLinks)
    {
        if (is_numeric($trackLinks)) {
            if ($trackLinks > 1 || $trackLinks < 0) {
                throw new InvalidArgumentException(
                    'Invalid value supplied for Account::setTrackLinks()'
                );
            }

            $trackLinks = (bool)$trackLinks;
        } elseif (!is_bool($trackLinks)) {
            throw new InvalidArgumentException(
                'Invalid value supplied for Account::setTrackLinks()'
            );
        }

        $this->trackLinks = $trackLinks;

        return $this;
    }

    /**
     * Getter for track links
     *
     * @return boolean
     */
    public function getTrackLinks()
    {
        return $this->trackLinks;
    }

    /**
     * Setter for track opens
     *
     * @param boolean|string $trackOpens
     */
    public function setTrackOpens($trackOpens)
    {
        if (is_numeric($trackOpens)) {
            if ($trackOpens > 1 || $trackOpens < 0) {
                throw new InvalidArgumentException(
                    'Invalid value supplied for Account::setTrackOpens()'
                );
            }

            $trackOpens = (bool)$trackOpens;
        } elseif (!is_bool($trackOpens)) {
            throw new InvalidArgumentException(
                'Invalid value supplied for Account::setTrackOpens()'
            );
        }

        $this->trackOpens = $trackOpens;

        return $this;
    }

    /**
     * Getter for track opens
     *
     * @return boolean
     */
    public function getTrackOpens()
    {
        return $this->trackOpens;
    }

    /**
     * Setter for test mode
     *
     * @param string $testMode
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * Getter for test mode
     *
     * @return string
     */
    public function getTestMode()
    {
        return $this->testMode;
    }

    /**
     * Setter for track unsubscribes
     *
     * @param boolean|string $trackUnsubscribes
     */
    public function setTrackUnsubscribes($trackUnsubscribes)
    {
        if (is_numeric($trackUnsubscribes)) {
            if ($trackUnsubscribes > 1 || $trackUnsubscribes < 0) {
                throw new InvalidArgumentException(
                    'Invalid value supplied for Account::setTrackUnsubscribes()'
                );
            }

            $trackUnsubscribes = (bool)$trackUnsubscribes;
        } elseif (!is_bool($trackUnsubscribes)) {
            throw new InvalidArgumentException(
                'Invalid value supplied for Account::setTrackUnsubscribes()'
            );
        }

        $this->trackUnsubscribes = $trackUnsubscribes;

        return $this;
    }

    /**
     * Getter for track unsubscribes
     *
     * @return boolean
     */
    public function getTrackUnsubscribes()
    {
        return $this->trackUnsubscribes;
    }

    /**
     * Setter for max sample count
     *
     * @param integer $maxSampleCount
     */
    public function setMaxSampleCount($maxSampleCount)
    {
        $this->maxSampleCount = $maxSampleCount;

        return $this;
    }

    /**
     * Getter for max sample count
     *
     * @return integer
     */
    public function getMaxSampleCount()
    {
        return $this->maxSampleCount;
    }

    /**
     * Setter for contact name
     *
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Getter for contact name
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Setter for emails sent
     *
     * @param integer $emailsSent
     */
    public function setEmailsSent($emailsSent)
    {
        $this->emailsSent = $emailsSent;

        return $this;
    }

    /**
     * Getter for emails sent
     *
     * @return integer
     */
    public function getEmailsSent()
    {
        return $this->emailsSent;
    }
}
