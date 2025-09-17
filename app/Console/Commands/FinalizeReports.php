<?php

// app/Console/Commands/FinalizeReports.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OpsRoom;
use Carbon\Carbon;

class FinalizeReports extends Command
{
    protected $signature = 'reports:finalize';
    protected $description = 'Finalize recallable reports after 5 minutes';

    public function handle()
    {
        $now = Carbon::now();
        $reports = OpsRoom::where('status','recallable')
                          ->where('scheduled_submit_at','<=',$now)
                          ->get();

        foreach ($reports as $report) {
            $report->update([
                'status'       => 'pending_dland',
                'submitted_at' => $now,
            ]);
        }

        $this->info("Finalized {$reports->count()} reports.");
    }
}
