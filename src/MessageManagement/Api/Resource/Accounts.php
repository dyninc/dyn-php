<?php

namespace Dyn\MessageManagement\Api\Resource;

use Dyn\MessageManagement\Account;
use RuntimeException;

class Accounts extends AbstractResource
{
    /**
     * Returns details for the account the current API key belongs to.
     *
     * Note: there isn't an API call for this, the function works by looping
     * through all the accounts returned by getAccounts(). This could be slow
     * when called from a master account with a large number of sub-accounts.
     *
     * @return Account|false
     */
    public function get()
    {
        $apiKey = $this->getApiClient()->getApiKey();

        $startIndex = 0;
        while (($accounts = $this->getAll($startIndex)) !== false) {
            foreach ($accounts as $account) {
                if ($account->getApiKey() == $apiKey) {
                    return $account;
                }
            }

            $startIndex += 25;
        }

        return false;
    }

    /**
     * Returns up to 25 accounts
     *
     * @param  integer $startIrom Optional start index
     * @return array
     */
    public function getAll($startIndex = 0)
    {
        $params = array();
        if ($startIndex) {
            $params = array('startindex' => $startIndex);
        }

        $response = $this->getApiClient()->get('/accounts', $params);
        if ($response && $response->isOk()) {
            $accounts = array();

            foreach ($response->data->accounts as $accountData) {
                $account = Account::fromJson($accountData);
                $accounts[] = $account;
            }

            return $accounts;
        }

        return false;
    }

    /**
     * Create a new sub account.
     *
     * Returns the resulting account object with the API key populated.
     *
     * @param  Account $account
     * @return Account|false
     */
    public function create(Account $account)
    {
        $params = $account->toApiParams();

        // Make sure all the required fields are present
        $requireFields = array('username', 'password', 'companyname', 'phone');
        foreach ($requireFields as $requiredField) {
            if (empty($params[$requiredField])) {
                throw new RuntimeException(
                    "Unable to create an account without a '$requiredField' field"
                );
            }
        }

        $response = $this->getApiClient()->post('/accounts', $params);
        if ($response && $response->isOk()) {
            // add the resulting API key to the account instance
            $account->setApiKey($response->data->apikey);

            return $account;
        }

        return false;
    }

    /**
     * Update an account
     *
     * @param  Account $account
     * @return Account|false
     */
    public function update(Account $account)
    {
        $params = $account->toApiParams();

        // Make sure all the required fields are present
        $requireFields = array('username', 'companyname', 'phone');
        foreach ($requireFields as $requiredField) {
            if (empty($params[$requiredField])) {
                throw new RuntimeException(
                    "Unable to update an account without a '$requiredField' field"
                );
            }
        }

        $response = $this->getApiClient()->post('/accounts', $params);
        if ($response && $response->isOk()) {
            // add the resulting API key to the account instance
            $account->setApiKey($response->data->apikey);

            return $account;
        }

        return false;
    }

    /**
     * Delete an account
     *
     * @param  Account $account
     * @return boolean
     */
    public function delete(Account $account)
    {
        $params = array(
            'username' => $account->getUsername()
        );

        $response = $this->getApiClient()->post('/accounts/delete', $params);
        if ($response && $response->isOk()) {
            return true;
        }

        return false;
    }
}
