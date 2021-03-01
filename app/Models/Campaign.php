<?php

namespace App\Models;

use GravityLending\Mass\Models\Massive;
use GravityLending\Mass\Http\Traits\{HasRoutes, HasFile};

class Campaign extends Massive
{
    use HasFile, HasRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaigns';

    /**
     * The properties for HasFile trait
     *
     * @var string
     */
    public static $fileProperties = [
        'directory' => 'promos',
        'extensions' => ['csv'],
        'commands' => ['created' => 'process:campaign'],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'name',
        'expired_at',
        'campaign_type_id',
        'file'
    ];

    /**
     * The validation rules for requests
     *
     * @var array
     */
    public static $rules = [
        'active' => 'boolean',
        'name' => 'required|string|unique:campaigns',
        'expired_at' => 'required|date_format:Y-m-d H:i:s',  // todo: after_or_equal:date
        'campaign_type_id' => 'required|exists:campaign_types',
        'file' => 'required|mimes:csv|max:2048',
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
     * Get the campaign type
     */
    public function type()
    {
        return $this->hasOne(CampaignType::class, 'id', 'campaign_type_id');
    }

    /**
     * Get the campaign's promos
     */
    public function promos()
    {
        return $this->hasMany(PromoCode::class);
    }
}
