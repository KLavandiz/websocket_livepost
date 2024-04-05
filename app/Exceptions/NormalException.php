<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NormalException extends Exception
{
    protected $message = 'An error occurred';

    protected $code = 500;

    public function report()
    {
        //When an error occurred to send an email development team!
    }

    public function render($request)
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->getMessage() ?? $this->message
            ]
        ], $this->code);
    }
}
