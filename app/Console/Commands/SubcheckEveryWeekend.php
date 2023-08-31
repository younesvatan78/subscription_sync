<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CheckSubStatusService;

class SubcheckEveryWeekend extends Command
{
    protected $description = 'Checking the status of subscriptions';
    protected $signature = 'subscription:check';
    public function handle()
    {
        $synchronizationService = new CheckSubStatusService();
        $synchronizationService->subcheckstatus();
    }
}
