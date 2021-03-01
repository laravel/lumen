<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Controllers;

use GravityLending\Mass\Http\Resources\ApiResource;
use Laravel\Lumen\Http\Request;
use Laravel\Lumen\Routing\Controller;

class Mass extends Controller
{
    protected $model;

    public function __construct()
    {
        $model = app('request')->get('model');
        $this->model = new $model;
    }


    /**
     * @param ApiRequest $request
     * @param Route $route
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store (Request $request) {
        if($model = $this->model::create($request->all())) {
            return response()->json(new ApiResource($model), 201);
        } else {
            return 'some store error';
        }
    }

    public function index()
    {
        return $this->model::paginate();
    }

    /**
     * @param $model
     * @return ApiResource
     */
    public function show ($id) {
        $model = $this->model::findOrFail($id);
        return new ApiResource($model);
    }


    /**
     * @param ApiRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request, $id)
    {
        if($this->model->update($request->all())) {
            return response()->json(new ApiResource($this->model), 202);
        } else {
            return response()->json([
                'error' => 'Method Not Allowed'], '403'
            );
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|string
     */
    public function destroy ($id) {
        $model = $this->model::findOrFail($id);
        if($model->delete()) {
            return response()->noContent();
        } else {
            return 'some delete error';
        }
    }
}
