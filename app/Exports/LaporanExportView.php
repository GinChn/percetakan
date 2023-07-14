<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExportView implements FromView
{
    protected $data_laporan;
    protected $data_input;

    public function __construct($data_laporan, $data_input)
    {
        $this->data_laporan = $data_laporan;
        $this->data_input = $data_input;
    }

    public function view(): View
    {
        return view('laporan.tabel', [
            'data_laporan' => $this->data_laporan,
            'data_input' => $this->data_input,
        ]);
    }
}
