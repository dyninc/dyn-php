<?php

namespace Dyn\MessageManagement\Api\Resource;

class Recipients extends AbstractResource
{
    /**
     * Returns the status of an email address sent through the account
     *
     * Returns an array of recipients and their status.  Note that an 
     * array is returned regardless of whether one or many addresses
     * are requested
     *
     * @param  string|array  $emailaddress  Recipient email address
     * @return array|false
     */
    public function getStatus($emailAddress)
    {
        if (!is_array($emailAddress)) {
            $emailAddress = array($emailAddress);
        }
        $params = array(
            'emailaddress' => implode(',', $emailAddress)
        );

        $result = $this->getApiClient()->get('/recipients/status', $params);
        if ($result && $result->isOk()) {
            return $result->data->recipients;
        }

        return false;
    }

}
