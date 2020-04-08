<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
class FindFavoriteOS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rawData = file_get_contents('https://api.vultr.com/v1/os/list');
        $list = json_decode($rawData, true);
        shuffle($list);
        $key = array_rand($list);
        $favorite = $list[$key];
        Log::info('My Favorite OS is: ' . $favorite['name']);
    }
}
