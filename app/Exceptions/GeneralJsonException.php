<?php

namespace App\Exceptions;

use Exception;

class GeneralJsonException extends Exception
{
    public function render($request)
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->getMessage(),
            ]
        ], $this->code());
    }
}
