<?php

namespace App\Jobs;

use App\Exports\TicketExport;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketExportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $submit_start;
    protected $submit_end;
    protected $status;
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $status, $submit_start, $submit_end)
    {
        $this->submit_start = $submit_start;
        $this->submit_end = $submit_end;
        $this->status = $status;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exporter = new TicketExport();
        $exporter->setStatus($this->status);
        $exporter->setSubmitTime($this->submit_start, $this->submit_end);

        $exporter->store('public/' . $this->filename);
    }
}
