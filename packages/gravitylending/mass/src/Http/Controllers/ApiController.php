<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use GravityLending\Mass\Http\Requests\ApiRequest;
use GravityLending\Mass\Http\Resources\ApiResource;

class ApiController extends Controller
{
    protected $route;
    protected $model;

    /**
     * Get model class via route
     * @param Route $route
     * @return string
     */
    protected function getModelClass (Route $route) : string {
        [$as, $method] = [$route->getName(), $route->getActionMethod()];
        $action = Str::beforeLast($as, '.'.$method);
        return config('mass.namespace') . $action;
    }

    /**
     * @param Route $route
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index (Route $route) {
        $class = $this->getModelClass($route);
        return ApiResource::collection($class::paginate());
    }

    /**
     * @param $model
     * @return ApiResource
     */
    public function show (Model $model) : ApiResource {
        return new ApiResource($model);
    }

    /**
     * @param ApiRequest $request
     * @param Route $route
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store (ApiRequest $request, Route $route) {
        $class = $this->getModelClass($route);
        if($model = $class::create($request->all())) {
            return response()->json(new ApiResource($model), 201);
        } else {
            return 'some store error';
        }
    }

    /**
     * @param ApiRequest $request
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (ApiRequest $request, $model) {
        if($model->update($request->all())) {
            return response()->json(new ApiResource($model), 202);
        } else {
            return response()->json([
                'error' => 'Method Not Allowed'], '403'
            );
        }
    }

    /**
     * @param $model
     * @return \Illuminate\Http\Response|string
     */
    public function destroy ($model) {
        if($model->delete()) {
            return response()->noContent();
        } else {
            return 'some delete error';
        }
    }
}
