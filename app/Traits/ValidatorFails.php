<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ValidatorFails
{
    protected function sendValidationErrors($validator)
    {
        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
