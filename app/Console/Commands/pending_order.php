<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class pending_order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pending_order';

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
        echo"vikesh";
    }
}
