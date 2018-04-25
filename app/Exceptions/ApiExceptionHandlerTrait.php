<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ApiExceptionHandlerTrait
{
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch (true) {
            case $this->is403Exception($e):
                $response = $this->jsonExceptionResponseWithDefaultMessage(403, $e, 'Forbidden');
                break;
            case $this->is404Exception($e):
                $response = $this->jsonExceptionResponseWithDefaultMessage(404, $e, 'Not found');
                break;
            case $this->isValidationException($e):
                $response = $this->jsonExceptionResponse(400, $e, $this->getFirstErrorFromValidateException($e));
                break;
            default:
                $response = $this->jsonExceptionResponseWithDefaultMessage(400, $e);
        }

        return $response;
    }

    /**
     * @param ValidationException $e
     * @return mixed
     */
    private function getFirstErrorFromValidateException(ValidationException $e)
    {
        $listError = $e->errors();

        return array_first(array_shift($listError));
    }

    /**
     * @param Exception $e
     * @return bool
     */
    private function isValidationException(\Exception $e)
    {
        return $e instanceof ValidationException;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    private function is404Exception(\Exception $e) : bool
    {
        if ($e->getCode() == 404) {
            return true;
        }

        if ($this->getStatusExceptionIfExist($e) == 404) {
            return true;
        }

        if ($e instanceof ModelNotFoundException) {
            return true;
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return true;
        }

        return false;
    }

    /**
     * @param Exception $e
     * @return bool
     */
    private function is403Exception(\Exception $e) : bool
    {
        if ($e->getCode() == 403) {
            return true;
        }

        if ($this->getStatusExceptionIfExist($e) == 403) {
            return true;
        }

        return false;
    }

    /**
     * @param Exception $e
     * @return int|null
     */
    private function getStatusExceptionIfExist(\Exception $e) : ?int
    {
        if (! method_exists ($e, 'getStatusCode')) {
            return null;
        }

        return $e->getStatusCode();
    }

    /**
     * @param int $statusCode
     * @param Exception $e
     * @param string $defaultMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonExceptionResponseWithDefaultMessage(int $statusCode, \Exception $e, string $defaultMessage = 'Bad request')
    {
        $errorMessage = $e->getMessage() ?? $defaultMessage;

        return $this->jsonExceptionResponse($statusCode, $e, $errorMessage);
    }

    /**
     * @param int $statusCode
     * @param Exception $e
     * @param string $errorMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonExceptionResponse(int $statusCode, \Exception $e, string $errorMessage)
    {
        $errorInfo = $this->getErrorInfo($errorMessage, $statusCode, $e);

        return response()->json(['error' => $errorInfo], $statusCode);
    }

    /**
     * @param $message
     * @param $statusCode
     * @param Exception $e
     * @return array
     */
    protected function getErrorInfo($message, $statusCode, \Exception $e) : array
    {
        $errorInfo = [
            'code' => $e->getCode(),
            'statusCode' => $statusCode,    // duplicate http status code
            'message' => $message,
            'type' => get_class($e),
        ];

        if (env('APP_DEBUG')) {
            // TODO: add additions debug info if need
            $errorInfo = array_merge($errorInfo, ['stackTrace' => $e->getTraceAsString()]);
        }

        return $errorInfo;
    }
}