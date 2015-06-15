<?php namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
}
