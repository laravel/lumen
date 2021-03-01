<?php

namespace App\Models;

use GravityLending\Mass\Models\Massive;
use GravityLending\Mass\Http\Traits\HasRoutes;

class CampaignType extends Massive
{
    use HasRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaign_types';

    /**
     * The route properties for HasRoutes trait
     *
     * @var array
     */
    public static $routing = ['resource' => 'type'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'name',
    ];

    /**
     * The validation rules for requests
     *
     * @var array
     */
    public static $rules = [
        'active' => 'boolean',
        'name' => 'required|string'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * Get the type campaigns
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
