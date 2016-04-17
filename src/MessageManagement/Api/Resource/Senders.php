<?php

namespace Dyn\MessageManagement\Api\Resource;

use DateTime;
use Dyn\MessageManagement\Sender;
use Dyn\MessageManagement\Api\Resource\Senders\Status;
use Dyn\MessageManagement\Api\Resource\Senders\Details;
use Dyn\MessageManagement\Api\Resource\Senders\Dkim;

class Senders extends AbstractResource
{

    /**
     * @var Dkim
     */
    protected $dkim = null;

    /**
     * Returns up to 25 approved senders
     *
     * @param  integer $startIndex Optional start index
     * @param  array $extras Optional list of extras to fetch {status,details}
     * @return array|false
     */
    public function get($startIndex = 0, $extras=[])
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

                if (in_array('status', $extras)) {
                    $status = new Status($this->getApiClient());
                    $status->get($sender);
                }

                if (in_array('details', $extras)) {
                    $details = new Details($this->getApiClient());
                    $details->get($sender);
                }

                $senders[] = $sender;
            }

            return $senders;
        }

        return false;
    }

    /**
     * Return an instance of the Dkim API Resource
     * 
     * @return Dkim $dkim
     */
    public function dkim()
    {
        if ($this->dkim === null) {
            $this->dkim = new Dkim($this->getApiClient());
        }

        return $this->dkim;
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
