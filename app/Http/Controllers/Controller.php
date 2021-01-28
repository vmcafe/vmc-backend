<?php

namespace App\Http\Controllers;
use App\Context\Handler;
use App\Context\Reader;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class Controller extends BaseController
{
    public function responseSuccess($response, $code = 200)
    {
        $responseSuccess = [
            'data' => $response,
            'message' => 'Success',
            'code' => $code,
        ];
        return new JsonResponse($responseSuccess, $code);
    }

    public function responseException(\Exception $e)
    {
        $code = $e->getCode();

        if ($code <= 0 || $code > 500) {
            $code = 500;
        }

        $message = $e->getMessage() . " file " . $e->getFile() . " in line " . $e->getLine();
        if (method_exists($e, 'errors')) {
            $message = $e->errors();
        }

        $responseException = [
            'user_message' => $e->getMessage(),
            'developer_message' => $message,
            'code' => $code,
        ];
        return new JsonResponse($responseException, $code);
    }
}