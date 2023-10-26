<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CallHotelsApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:hotels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Your API call logic here, you can include the code from your 'hotels' function.
            app()->call('App\Http\Controllers\api\hotels\ContentController@destinations');
            $this->info('API call was successful.');
        } catch (\Throwable $e) {
            // Handle any exceptions here
            $this->error($e->getMessage());
        }
    }
}
