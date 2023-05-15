<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generates and returns the api json response
     *
     * @param  array $responseData
     * @param  array $options
     *
     * @return JsonResponse
     */
    public function sendResponse(array $responseData, array $options = []): JsonResponse {
        if (isset($options['Authorization'])) {
            return response()->json($responseData, $options['HTTP_STATUS_CODE'])->withHeaders([
                'Authorization' => $options['Authorization']
            ]);
        }else{
            return response()->json($responseData, $options['HTTP_STATUS_CODE']);
        }
    }
}
