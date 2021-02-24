<?php

declare(strict_types=1);

namespace GravityLending\Mass\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class ApiHandler extends Handler
{
    public function render($request, Throwable $e)
    {
        if(method_exists($e, 'getModel')) {
            $model = str_replace(config('mass.namespace'), '', $e->getModel());
            $idParam = Arr::get(array_flip($request->route()->bindingFields()), 'id');
            $id = $idParam ? $request->route()->parameter($idParam) : null;
        }

        if ($e instanceof ValidationException) {
            $errors = [];
            foreach($e->errors() as $field => $error) {
                $errors[] = [
                    'source' => ['pointer' => '/data/attributes/' . $field],
                    'status' => $e->status,
                    'detail' => current($error)
                ];
            }
            return response()->json(['errors' => $errors], $e->status);
        }
        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => [
                'status' => 404,
                'code' => $e->getCode(),
                'detail' => 'Entry for ' . $model . ' ' . $id . ' not found'
            ]], 404);
        }

        // todo: 401(not auth), 403(logged in but forbidden), 400(bad request)

        return parent::render($request, $e);
    }
}
