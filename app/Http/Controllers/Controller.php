<?php

namespace App\Http\Controllers;

use App\Context\Handler;
use App\Context\Reader;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;


class Controller extends BaseController
{
    public function responseSuccess($data, $code = 200)
    {
        $struct = [
            'data' => $data,
            'message' => 'success',
            'code' => $code,
        ];

        return new JsonResponse($struct, $code);
    }

    public function responseException(\Exception $e)
    {
        $code = $e->getCode();

        if ($code <= 0 || $code > 500) {
            $code = 500;
        }

        $developerMessage = $e->getMessage() . " file " . $e->getFile() . " in line " . $e->getLine();
        if (method_exists($e, 'errors')) {
            $developerMessage = $e->errors();
        }

        $responseException = [
            'user_message' => $e->getMessage(),
            'developer_message' => $developerMessage,
            'code' => $code,
        ];
        return new JsonResponse($responseException, $code);

    }

    public function responsePagination(Reader $reader, $code = 200)
    {
        try {
            // dd(gettype($code));
            $data = $reader->toPagination();

            $responseSuccess = [
                'data' => $data->items(),
                'pagination' => [
                    'total' => $data->total(),
                    'size' => (int)$data->perPage(),
                    'page' => $data->currentPage(),
                ],
                'message' => 'Success',
                'code' => $code
            ];
            return new JsonResponse($responseSuccess, $code);
        } catch (\Exception $error) {
            return $this->responseException($error);
        }
    }

    public function executeHandler(Handler $handler, Request $request = null, $rules = [])
    {
        if (count($rules) > 0 && !is_null($request)) {
            $this->validate($request, $rules);
        }
        try {
            $data = $handler->handle();
            return $this->responseSuccess($data);
        } catch (\Exception $err) {
            return $this->responseException($err);
        }
    }

    public function executeReader(Reader $reader)
    {
        try {
            $data = $reader->read();
            return $this->responseSuccess($data);
        } catch (\Exception $err) {
            return $this->responseException($err);
        }
    }
}
