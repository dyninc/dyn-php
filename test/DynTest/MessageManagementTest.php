<?php

namespace DynTest;

use PHPUnit_Framework_TestCase;
use Dyn\MessageManagement;
use Dyn\MessageManagement\Account;

class MessageManagementTest extends PHPUnit_Framework_TestCase
{
    protected $mm;

    public function setUp()
    {
        $this->mm = new MessageManagement('xxxxxxxxxxxx');
        $this->mm->setApiClient(TestBootstrap::getTestMMApiClient());
    }

    public function testSend()
    {
        // TODO
        $this->assertTrue(true);
    }
}
