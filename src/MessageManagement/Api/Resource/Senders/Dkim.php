<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;
use \Dyn\MessageManagement\Api\Resource\AbstractResource;
use \Dyn\MessageManagement\Api\Resource\Senders\Details;

class Dkim extends AbstractResource {

    public function create(Sender $sender, $dkimIdentifier=false)
    {
        $params = array(
            'emailaddress' => $sender->getEmailAddress()
        );

        if (false === $dkimIdentifier) {
            $dkimIdentifier = uniqid();
        }

        $response = $this->getApiClient()->post('/senders/dkim', $params);
        if ($response && $response->isOK()) {
            $details = new Details();
            $details->get($sender);
            return true;
        }

        return false;
    }

}
