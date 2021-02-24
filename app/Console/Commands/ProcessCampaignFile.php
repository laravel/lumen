<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProcessCampaignFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:campaign {--A|artisan=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import PromoCodes from Campaign CSV';

    /**
     * CSV fields mapped to fillable PromoCode attributes
     *
     * @var string
     */
    protected $map = [
        'promocode' => 'code',
        'FNAME' => 'first_name',
        'LNAME' => 'last_name',
        'ADDR1' => 'address',
        'ADDR2' => 'address2',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(Storage::files(Campaign::$fileProperties['directory']) as $path) {
            $campaign = Campaign::where('file_name', str_replace(Campaign::$fileProperties['directory'] . '/', '', $path))->first();
            $csv = array_filter(explode("\n", Storage::get($path)));
            $header = explode(',',
                str_replace("\r", '', Arr::pull($csv, 0)));
            $data = [];
            foreach($csv as $line) {
                $header = array_map(function($key) {
                    return $this->map[$key] ?? trim(strtolower($key));
                }, $header);

                // todo: compare to validate CSV
                $data[] = array_combine(
                    $header,
                    explode(',', str_replace("\r", '', $line)));
            }
            data_fill($data, '*.active', true);
            if($campaign->promos()->createMany($data)){
                $this->output->text(count($data));
            } else {
                $this->error(0);
            }
            // todo: activate campaign upon completion
        }
        return 1;
    }
}
