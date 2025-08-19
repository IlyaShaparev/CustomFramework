<?php

namespace DeParis\Kernel\Http\Exceptions;

class HttpException extends \Exception
{
    private int $statusCode = 500;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }


}