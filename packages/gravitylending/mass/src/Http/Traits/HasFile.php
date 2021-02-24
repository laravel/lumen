<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    protected $fileProperties = [];
    protected $fileNameField = 'file_name';

    public static function bootHasFile()
    {
        if($commands = static::$fileProperties['commands']) {
            foreach($commands as $event => $cmd) {
                static::$event(function($model, $cmd){
                    Artisan::call($cmd);
                });
            }
        }
    }

    /**
     * Set file uploaded
     * @param File|null $file
     */
    public function setFileAttribute($value)
    {
        $file_name = time() . '.' . $value->getClientOriginalName();
        $value->storeAs(static::$fileProperties['directory'], $file_name);
        $this->attributes[$this->fileNameField] = $file_name;
    }

    public function getFileAttribute()
    {
        return Storage::get(static::$fileProperties['directory'] . '/' . $this->attributes[$this->fileNameField]);
    }
}
