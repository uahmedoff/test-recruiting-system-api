<?php


namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
trait ResponseAble{

    protected function sendResponse($data = [], $message = '', $code = 200){
        return response()->json([
            'status' => 'success',
            'code'    => $code,
            'result'    => $data,
            'message' => $message
        ])->setStatusCode($code);
    }

    protected function sendError($data = [], $message = '', $code = 404){
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'code'    => $code,
                'errors'   => $data,
                'message' => $message
            ])->setStatusCode($code)
        );
    }

}
