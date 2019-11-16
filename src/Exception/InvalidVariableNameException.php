<?php


namespace Futape\PhpTemplate\Exception;


use RuntimeException;
use Throwable;

class InvalidVariableNameException extends RuntimeException
{
    public function __construct(string $name, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            '"' . $name . '" is not a valid variable name',
            $code,
            $previous
        );
    }
}
