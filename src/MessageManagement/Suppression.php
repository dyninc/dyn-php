<?php

namespace Dyn\MessageManagement;

use DateTime;

class Suppression
{
    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * Reason they were added to the suppression list. Possible values
     * include:
     *   hardbounce
     *   complaint
     *   manual
     *
     * @var string
     */
    protected $reasonType;

    /**
     * @var DateTime
     */
    protected $suppressTime;


    /**
     * Creates a new instance based on JSON data
     *
     * @param  stdClass $json
     * @return self
     */
    public static function fromJson($json)
    {
        $suppression = new static();
        $suppression->setEmailAddress($json->emailaddress)
                    ->setReasonType($json->reasontype)
                    ->setSuppressTime($json->suppresstime);

        return $suppression;
    }

    /**
     * Setter for email address
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Getter for email address
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Setter for reason type
     *
     * @param string $reasonType
     */
    public function setReasonType($reasonType)
    {
        $this->reasonType = $reasonType;

        return $this;
    }

    /**
     * Getter for reason type
     *
     * @return string
     */
    public function getReasonType()
    {
        return $this->reasonType;
    }

    /**
     * Setter for suppression time
     *
     * @param string|DateTime $suppressTime
     */
    public function setSuppressTime($suppressTime)
    {
        if (is_string($suppressTime)) {
            $suppressTime = new DateTime($suppressTime);
        }

        $this->suppressTime = $suppressTime;

        return $this;
    }

    /**
     * Getter for suppression time
     *
     * @return DateTime
     */
    public function getSuppressTime()
    {
        return $this->suppressTime;
    }
}
