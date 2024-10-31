<?php

declare(strict_types=1);

use Psr\Http\Client\ClientExceptionInterface;

class RequestFailedException extends RuntimeException implements ClientExceptionInterface
{
}
