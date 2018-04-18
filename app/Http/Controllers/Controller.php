<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Return an error response to the user
     *
     * @param string $message
     * @param int    $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError(string $message, int $code = 500)
    {
        return response()->json(['error' => $message], $code);
    }
}
