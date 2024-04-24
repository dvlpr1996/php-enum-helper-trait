<?php

namespace dvlpr1996\PhpEnumHelperTrait\Exceptions;

class XmlException extends \Exception
{
    public function __construct(string $message, int $statusCode = 500, $previous = null)
    {
        parent::__construct($message . ' File Path Not Exists', $statusCode, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__ . ' : ' . $this->message;
    }
}
