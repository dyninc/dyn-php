<?php

namespace Dyn\MessageManagement\Api\Http;

use Laminas\Http\Response as LaminasHttpResponse;

class Response extends LaminasHttpResponse
{
    const STATUS_CODE_451 = 451; // Missing or invalid API key
    const STATUS_CODE_452 = 452; // Missing or invalid required fields
    const STATUS_CODE_453 = 453;
    const STATUS_CODE_454 = 454; // Feature not enabled
}
