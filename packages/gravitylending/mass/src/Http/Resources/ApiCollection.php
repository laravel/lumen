<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiCollection extends ResourceCollection
{

//    public $collects = Member::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
