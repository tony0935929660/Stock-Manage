<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function createApiResponse($rawContent = null, $status = Response::HTTP_OK, $headers = array()): Response
    {
        $response = new Response($rawContent, $status, $headers);
        return $response;
    }

    protected function createHttpExceptionResponse($statusCode = Response::HTTP_BAD_REQUEST, ?string $reason = null, $headers = array()): Response
    {
        return $this->createApiResponse(['reason' => $reason], $statusCode, $headers);
    }

    protected function createValidatorErrorApiResponse(Validator $validator, $headers = array()): Response
    {
        return $this->createApiResponse([
            'reason' => 'Some data is invalid',
            'field' => $validator->errors()->all()
        ], Response::HTTP_BAD_REQUEST, $headers);
    }

    protected function createUnauthorizeApiResponse(?string $reason = null, $headers = array()): Response
    {
        return $this->createHttpExceptionResponse(Response::HTTP_UNAUTHORIZED, $reason, $headers);
    }
}
