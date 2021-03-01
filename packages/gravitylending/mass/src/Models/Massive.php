<?php

declare(strict_types=1);

namespace GravityLending\Mass\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Massive extends Model
{
//    protected static $routing;

    /**
     * @param $model
     * @param string $noun
     * @return string
     */
    public static function getResource($noun = 'singular'): string
    {
        if (! $name = static::$routing['resource'] ?? null) {
            $name = class_basename(get_class(static::class));
        }
        return Str::lower(Str::{$noun}($name));
    }

    public static function getBindKey($suffix = 'Id'): string
    {
        if(isset(static::$routing['bind'])) { // has prop
            return static::$routing['bind'];
        } else {
            $name = class_basename(get_class(static::class));
            return Str::snake($name . $suffix);
        }
    }
}
