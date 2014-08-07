<?php

namespace Dyn\MessageManagement\Api\Resource;

use DateTime;
use Dyn\MessageManagement\Sender;

class Senders extends AbstractResource
{
    /**
     * Returns up to 25 approved senders
     *
     * @param  integer $startIndex Optional start index
     * @return array|false
     */
    public function get($startIndex = 0)
    {
        $params = array();
        if ($startIndex) {
            $params = array('startindex' => $startIndex);
        }

        $response = $this->getApiClient()->get('/senders', $params);
        if ($response && $response->isOk()) {
            $response->data;

            $senders = array();
            foreach ($response->data->senders as $senderData) {
                $sender = new Sender();
                $sender->setEmailAddress($senderData->emailaddress);

                $senders[] = $sender;
            }

            return $senders;
        }

        return false;
    }

    /**
     * Create a new approved sender
     *
     * @param  Sender $sender
     * @return boolean
     */
    public function create(Sender $sender)
    {
        $params = array(
            'emailaddress' => $sender->getEmailAddress()
        );

        $response = $this->getApiClient()->post('/senders', $params);
        if ($response && $response->isOk()) {
            return true;
        }

        return false;
    }
}
