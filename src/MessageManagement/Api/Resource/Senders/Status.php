<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;
use \Dyn\MessageManagement\Api\Resource\AbstractResource;

class Status extends AbstractResource {

    /**
     * Get status of the sender and assign to provided instance of Sender
     *
     * @param Sender $sender
     * @return boolean
     */
    public function get(Sender $sender)
    {
        $params = array(
            'emailaddress' => $sender->getEmailAddress()
        );

        $response = $this->getApiClient()->get('/senders/status', $params);
        if ($response && $response->isOK()) {
            $sender->setIsReady((bool)$response->data->ready);
    
            return true;
        }

        return false;
    }

}
