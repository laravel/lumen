<?php namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

abstract class Job implements SelfHandling, ShouldBeQueued
{
    use InteractsWithQueue, SerializesModels;
}
