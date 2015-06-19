<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;

class Details extends \Dyn\MessageManagement\Api\Resource\AbstractResource {

    public function get(Sender $sender)
    {
        $params = array(
            'emailaddress' => $sender->getEmailAddress()
        );

        $response = $this->getApiClient()->get('/senders/details', $params);
        if ($response && $response->isOK()) {
            $sender->setDetails($response->data);

            return true;
        }

        return false;
    }

}
