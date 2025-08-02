<?php

namespace HotPayments\Exceptions;

class AuthorizationException extends HotpaymentsException
{
    public function __construct(string $message, int $code = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}