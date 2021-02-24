<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // todo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Route $route) : Array
    {
        $class = $this->getModelClass($route);
        return $class::$rules ?? [];
    }

    // todo remove duplicate helper class
    protected function getModelClass (Route $route) : string {
        [$as, $method] = [$route->getName(), $route->getActionMethod()];
        $action = Str::beforeLast($as, '.'.$method);
        return config('mass.namespace') . $action;
    }
}
