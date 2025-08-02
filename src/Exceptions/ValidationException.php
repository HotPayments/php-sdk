<?php

namespace HotPayments\Exceptions;

class ValidationException extends HotpaymentsException
{
    protected array $errors;

    public function __construct(string $message, array $errors = [], int $code = 422, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}