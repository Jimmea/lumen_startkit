<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 7/31/19
 * Time: 07:24
 */

namespace App\Traits;
use Illuminate\Http\Response;


trait APIResponse
{
    public function successResponse($data = [], $status = 'success', $code = Response::HTTP_OK, $message = '')
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
    public function failureResponse($status = 'error', $code = Response::HTTP_INTERNAL_SERVER_ERROR, $message = '')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'code' => $code
        ]);
    }
}