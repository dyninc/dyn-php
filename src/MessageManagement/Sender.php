<?php

namespace Dyn\MessageManagement;

class Sender
{
    /**
     * @var string
     */
    protected $emailAddress;


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
}
