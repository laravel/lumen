<?php

namespace App\Models;

use GravityLending\Mass\Models\Massive;
use GravityLending\Mass\Http\Traits\HasRoutes;

class PromoCode extends Massive
{
    use HasRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promocodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'code',
        'first_name',
        'last_name',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'lender',
        'funded_amount',
        'total_revenue',
        'campaign_id',
    ];

    public static $routing = ['resource' => 'promos'];

    /**
     * The validation rules for requests
     *
     * @var array
     */
    public static $rules = [
        'active' => 'boolean',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'address' => 'required|string',
        'address2' => 'string',
        'city' => 'required|string',
        'state' => 'required|string|max:2',
        'zip' => 'required|digits:5',
        'lender' => 'required|string',
        'funded_amount' => 'numeric',
        'total_revenue' => 'numeric',
        'campaign_id' => 'required|exists:campaigns',
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
     * Get the campaign associated with the promo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Search for input promo code
     */
    public static function search($value)
    {
        return is_numeric($value) ?
            PromoCode::findOrFail($value) :
            PromoCode::all()->firstWhere('code', $value);
    }


    public function funded() {
        return $this->attribute['funded_amount'] ?? false;
    }
}
