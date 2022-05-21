<?php

namespace App\Hr\Traits;

use App\Exceptions\BusinessRuleViolationException;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Psy\Exception\FatalErrorException;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorizedException;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait RestExceptionHandler
{
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param  Throwable  $th
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Throwable $th)
    {
        $exceptionsMap = [
            'isAuthenticationException' => 'notAuthenticated',
            'isBadRequestException' => 'badRequest',
            'isBusinessRuleViolationException' => 'businessRuleViolationException',
            'isErrorException' => 'errorException',
            'isFatalErrorException' => 'fatalError',
            'isFileNotFoundException' => 'fileNotFound',
            'isInvalidArgumentException' => 'invalidArgument',
            'isMethodNotAllowedHttpException' => 'methodNotAllowed',
            'isModelNotFoundException' => 'modelNotFound',
            'isNotFoundHttpException' => 'notFoundHttpRequest',
            'isQueryException' => 'queryException',
            'isUnauthorizedException' => 'notAuthorized',
        ];

        foreach ($exceptionsMap as $key => $value) {
            if ($this->{$key}($th)) {
                return $this->{$value}($th->getMessage());
            }
        }

        return $this->isValidationException($th) ?
            $this->validationError($th) :
            $this->errorException($th->getMessage());
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Bad request!', $statusCode = 400)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message = 'Model Not Found!', $statusCode = 404)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * Returns json response for query exception.
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function queryException($message = 'Unable to execute the query!', $statusCode = 500)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * Returns json response for HTTP method not allowed exception.
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function methodNotAllowed($message = 'Method Not Allowed!', $statusCode = 405)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * [notFoundHttpRequest description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function notFoundHttpRequest($message = 'Endpoint not found!', $statusCode = 404)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * [notAuthenticated description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function notAuthenticated($message = 'Unauthenticated!', $statusCode = 401)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * [notAuthorized description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function notAuthorized($message = 'Unauthorized!', $statusCode = 403)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * Returns json response for validation exception.
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function validationError(ValidationException $th, $message = 'Invalid parameters!', $statusCode = 400)
    {
        return $this->respondWithError($message, $statusCode, $th->validator->errors());
    }

    /**
     * [fatalError description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function fatalError($message = 'Fatal Error!', $statusCode = 500)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * [errorException description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function errorException($message = 'An unexpected error has occurred.', $statusCode = 500)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * [businessRuleViolationException description].
     *
     * @param  string  $message    [description]
     * @param  int  $statusCode [description]
     * @return json
     */
    protected function businessRuleViolationException($message = 'Business Rule Violation', $statusCode = 400)
    {
        return $this->respondWithError($message, $statusCode);
    }

    protected function fileNotFound($message = 'File not found!', $statusCode = 404)
    {
        return $this->respondWithError($message, $statusCode);
    }

    protected function invalidArgument($message = 'Invalid Argument!', $statusCode = 400)
    {
        return $this->respondWithError($message, $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param  array|null  $payload
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, $statusCode = 404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param  Throwable  $th
     * @return bool
     */
    protected function isModelNotFoundException(Throwable $th)
    {
        return $th instanceof ModelNotFoundException;
    }

    /**
     * [isQueryException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isQueryException(Throwable $th)
    {
        return $th instanceof QueryException;
    }

    /**
     * [isValidationException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isValidationException(Throwable $th)
    {
        return $th instanceof ValidationException;
    }

    /**
     * [isMethodNotAllowedHttpException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isMethodNotAllowedHttpException(Throwable $th)
    {
        return $th instanceof MethodNotAllowedHttpException;
    }

    /**
     * [isNotFoundHttpException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isNotFoundHttpException(Throwable $th)
    {
        return $th instanceof NotFoundHttpException;
    }

    /**
     * [isAuthenticationException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isAuthenticationException(Throwable $th)
    {
        return $th instanceof AuthenticationException;
    }

    /**
     * [isFatalErrorException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isFatalErrorException(Throwable $th)
    {
        return $th instanceof FatalErrorException;
    }

    /**
     * [isErrorException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isErrorException(Throwable $th)
    {
        return $th instanceof ErrorException;
    }

    /**
     * [isBusinessRuleViolationException description].
     *
     * @param  Throwable  $th [description]
     * @return bool      [description]
     */
    protected function isBusinessRuleViolationException(Throwable $th)
    {
        return $th instanceof BusinessRuleViolationException;
    }

    protected function isFileNotFoundException(Throwable $th)
    {
        return $th instanceof FileNotFoundException;
    }

    protected function isInvalidArgumentException(Throwable $th)
    {
        return $th instanceof InvalidArgumentException;
    }

    protected function isBadRequestException(Throwable $th)
    {
        return $th instanceof BadRequestException;
    }

    protected function isUnauthorizedException(Throwable $th)
    {
        return $th instanceof UnauthorizedException || $th instanceof SpatieUnauthorizedException;
    }

    private function respondWithError($message, $statusCode, $details = null)
    {
        $error = [
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if (!empty($details)) {
            $error['details'] = $details;
        }

        return $this->jsonResponse(['error' => $error], $statusCode);
    }
}
