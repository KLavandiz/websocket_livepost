<?php

namespace App\Helpers\Exception;

use App\Exceptions\NormalException;

class GeneralException
{
    static public function throw(bool $condition, $message, $code = 500)
    {
        throw_if($condition, NormalException::class, $message, $code);
    }

}
