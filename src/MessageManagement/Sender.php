<?php

namespace Dyn\MessageManagement;

class Sender
{
    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var bool
     */
    protected $isReady;


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
     * Setter for isReady (from /senders/status)
     *
     * @param bool $isReady
     */
    public function setIsReady($isReady)
    {
        $this->isReady = $isReady;

        return $this;
    }

    /**
     * Getter for isReady (from /senders/status)
     *
     * @return bool
     */
    public function isReady()
    {
        return $this->isReady;
    }

    /**
     * Setter for details about the sender
     *
     * @param stdClass $details
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Getter for dkimIsVerified (inside details)
     *
     * @return bool $dkimIsVerified
     */
    public function dkimIsVerified()
    {
        return (bool)$this->details->dkim;
    }

    /**
     * Getter for dkimValue (inside details)
     *
     * @return string $dkimValue
     */
    public function getDkimValue()
    {
        return $this->details->dkimval;
    }

    /**
     * Getter for spfIsVerified (inside details)
     * 
     * @return bool $spfIsVerified
     */
    public function spfIsVerified()
    {
        return (bool)$this->details->spf;
    }
}
