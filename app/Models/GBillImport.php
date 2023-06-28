<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class GBillImport extends Model
{
    //
    protected $table = 'g_bill_import';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * 获取拥有此电话的用户
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(GUser::class, 'user_id');
    }

}
