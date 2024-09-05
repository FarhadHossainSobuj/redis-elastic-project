<?php

namespace App\Console\Commands;

use App\Jobs\TransferMoneyJob;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class Generate100QueueJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate100-queue-jobs';

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
        for ($i = 1; $i <= 100; $i++) {
            $amount = rand(90, 110);
            $queue = Arr::random(["default", "custom"], 1)[0];
            echo "BDT $amount to Queue: $queue \n";
            dispatch(new TransferMoneyJob($amount))->onQueue($queue);
        }
        echo "100 queue jobs created";
    }
}
