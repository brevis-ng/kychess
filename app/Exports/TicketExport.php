<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class TicketExport implements FromQuery
{
    use Exportable;

    private $table = 'tickets';
    private $submit_start;
    private $submit_end;
    private $audited_time;
    private $status = ['pending', 'accepted', 'rejected'];

    public function setSubmitTime($submit_start, $submit_end)
    {
        $this->submit_start = $submit_start;
        $this->submit_end = $submit_end;
    }

    public function setAuditedTime($audited_start, $audited_end)
    {
        $this->audited_time = [$audited_start, $audited_end];
    }

    public function setStatus($status)
    {
        if ( $status ) {
            $this->status = $status;
        }
    }

    public function query()
    {
        return DB::table($this->table)
            ->whereIn('status', $this->status)
            ->when($this->submit_start, function ($query) {
                return $query->whereDate('created_at', '>=', $this->submit_start);
            })
            ->when($this->submit_end, function ($query) {
                return $query->whereDate('created_at', '<=', $this->submit_end);
            })
            ->orderBy('id', 'desc')->dump();
    }
}
