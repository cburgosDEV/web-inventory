<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $errorCode;
    protected $statusCode;

    public function __construct($message, $errorCode = 'CUSTOM_ERROR', $statusCode = 400)
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'error_code' => $this->errorCode,
            'message' => $this->getMessage(),
        ], $this->statusCode);
    }
}
