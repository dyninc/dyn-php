<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;
use \Dyn\MessageManagement\Api\Resource\AbstractResource;
use \Dyn\MessageManagement\Api\Resource\Senders\Details;

class Dkim extends AbstractResource {

    public function create(Sender $sender, $dkimIdentifier=false)
    {
        if (false === $dkimIdentifier) {
            $dkimIdentifier = uniqid();
        }

        $params = array(
            'emailaddress' => $sender->getEmailAddress(),
            'dkim' => $dkimIdentifier
        );

        $response = $this->getApiClient()->post('/senders/dkim', $params);
        if ($response && $response->isOK()) {
            $details = new Details($this->getApiClient());
            $details->get($sender);
            return true;
        }

        return false;
    }

}
