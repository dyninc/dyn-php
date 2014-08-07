<?php
/**
 * This example creates a new sub account
 */

require '../../vendor/autoload.php';

use Dyn\MessageManagement;
use Dyn\MessageManagement\Account;

$mm = new MessageManagement('YOUR API KEY');

// setup the account
$account = new Account();
$account->setUsername('user@example.com')
        ->setPassword('hCQLNuOKsrt57Uf')
        ->setCompanyName('Dyn')
        ->setPhone('603-123-1234');

// create it
$mm->accounts()->create($account);
