<?php 

namespace Dyn\MessageManagement\Api\Resource\Senders;

use \Dyn\MessageManagement\Sender;
use \Dyn\MessageManagement\Api\Resource\AbstractResource;
use \Dyn\MessageManagement\Api\Resource\Senders\Details;

class Dkim extends AbstractResource {

    /**
     * Create DKIM selector, optionally using the provided selector
     *
     * @param Sender $sender
     * @param string $dkimIdentifier Optional selector to assign to domain's DKIM
     * @return boolean
     */
    public function create(Sender $sender, $dkimIdentifier=false)
    {
        if (false === $dkimIdentifier) {
            $dkimIdentifier = uniqid();
        }

        $params = array(
            'emailaddress' => $sender->getEmailAddress(),
            'dkim' => $dkimIdentifier
        );

        // Assignment of a new selector should be rare and we're extremely likely
        // to want the public keys after, so we'll go ahead and refresh details which
        // which contain the DKIM records
        $response = $this->getApiClient()->post('/senders/dkim', $params);
        if ($response && $response->isOK()) {
            $details = new Details($this->getApiClient());
            $details->get($sender);
            return true;
        }

        return false;
    }

}
