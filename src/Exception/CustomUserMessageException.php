<?php

namespace App\Exception;

class CustomUserMessageException extends \Exception
{
    private $errors;

    public function __construct(string $message = '', array $errors = [], int $code = 0)
    {
        $this->errors = $errors;

        parent::__construct($message, $code);
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

}
