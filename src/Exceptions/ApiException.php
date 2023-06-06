<?php

declare(strict_types=1);

namespace adRespect\Exceptions;

use adRespect\Enums\HttpCode;
use Exception;

class ApiException extends Exception
{
    public function getStatus(): array
    {
        $code = $this->getCode();

        return [
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
            'http'    => HttpCode::getText($code),
        ];
    }
}
