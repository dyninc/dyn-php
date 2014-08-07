<?php

namespace Dyn\MessageManagement\Api\Http;

use Zend\Http\Response as ZendHttpResponse;

class Response extends ZendHttpResponse
{
    const STATUS_CODE_451 = 451; // Missing or invalid API key
    const STATUS_CODE_452 = 452; // Missing or invalid required fields
    const STATUS_CODE_453 = 453;
    const STATUS_CODE_454 = 454; // Feature not enabled
}
