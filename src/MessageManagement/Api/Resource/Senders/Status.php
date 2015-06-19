<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;

class Status extends \Dyn\MessageManagement\Api\Resource\AbstractResource {

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
