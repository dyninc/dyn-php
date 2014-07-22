<?php

namespace Dyn\TrafficManagement\Service;

use Dyn\TrafficManagement\Service\AbstractService;
use InvalidArgumentException;

class DynamicDNS extends AbstractService
{
    /**
     * @var string
     */
    protected $type = 'DDNS';

    /**
     * @var string
     */
    protected $address;

    /**
     * DNS record type, either 'A' or 'AAAA'
     *
     * @var string
     */
    protected $recordType;

    /**
     * Name of the user to create, or the name of an existing update user
     * to allow access to this service
     *
     * @var string
     */
    protected $username;

    /**
     * Total number of abusive updates since last good update
     *
     * @var integer
     */
    protected $abuseCount;

    /**
     * Boolean indicating whether or not the service is active
     *
     * @var boolean
     */
    protected $active;

    /**
     * Timestamp of the last good update by an update client
     *
     * @var integer
     */
    protected $lastUpdated;


    /**
     * Setter for address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $address = filter_var($address, FILTER_VALIDATE_IP);
        if ($address === false) {
            throw new InvalidArgumentException(
                'Invalid IP address supplied for DDNS service'
            );
        }

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
     * Setter for record type
     *
     * @param string $recordType
     */
    public function setRecordType($recordType)
    {
        if ($recordType != 'A' && $recordType != 'AAAA') {
            throw new InvalidArgumentException(
                'Invalid record type. Must be either A or AAAA'
            );
        }

        $this->recordType = $recordType;

        return $this;
    }

    /**
     * Getter for record type
     *
     * @return string
     */
    public function getRecordType()
    {
        return $this->recordType;
    }

    /**
     * Setter for user
     *
     * @param string $username
     */
    public function setUsername($username)
    {
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
     * Setter for abuse count
     *
     * @param integer $abuseCount
     */
    public function setAbuseCount($abuseCount)
    {
        if (!is_numeric($abuseCount)) {
            throw new \InvalidArguemtnException('Abuse count must be numeric');
        }

        $this->abuseCount = (int)$abuseCount;

        return $this;
    }

    /**
     * Getter for abuse count
     *
     * @return integer
     */
    public function getAbuseCount()
    {
        return $this->abuseCount;
    }

    /**
     * Setter for active
     *
     * @param mixed $active
     */
    public function setActive($active)
    {
        if ($active == 'Y') {
            $this->active = true;
        } elseif ($active == 'N') {
            $this->active = false;
        } elseif (is_bool($active)) {
            $this->active = $active;
        } else {
            throw new \InvalidArgumentException(
                "Invalid value supplied for 'active'. Must be either a " .
                "boolean, 'Y' or 'N'."
            );
        }

        return $this;
    }

    /**
     * Getter for active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Setter for last updated
     *
     * @param integer $lastUpdated
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Getter for last updated
     *
     * @return integer
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Getter for params data
     *
     * @return array
     */
    public function getParams()
    {
        $params =  array(
            'address' => $this->getAddress()
        );

        if (!empty($this->username)) {
            $params['full_setup'] = true;
            $params['user'] = $this->getUsername();
        }

        return $params;
    }
}
