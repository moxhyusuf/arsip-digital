<?php

namespace App\Exports;

use App\Models\Arsip;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $query = Arsip::with(['user', 'kategori']);

        if ($this->request->filled('tanggal_awal')) {
            $query->whereDate(
                'created_at',
                '>=',
                $this->request->tanggal_awal
            );
        }

        if ($this->request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $this->request->tanggal_akhir
            );
        }

        if ($this->request->filled('id_kategori')) {
            $query->where(
                'id_kategori',
                $this->request->id_kategori
            );
        }

        if ($this->request->filled('id_user')) {
            $query->where(
                'id_user',
                $this->request->id_user
            );
        }

        return $query->latest()->get()->map(function ($item) {

            return [
                'Tanggal' => $item->created_at->format('d-m-Y'),
                'No Registrasi' => $item->no_registrasi,
                'Unit Pengolah' => $item->user->nama,
                'Kategori' => $item->kategori->nama,
                'Nama Arsip' => $item->nama,
                'Status Retensi' => ucfirst($item->status_retensi),
                'Status Validasi' => ucfirst($item->status_validasi),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Registrasi',
            'Unit Pengolah',
            'Kategori',
            'Nama Arsip',
            'Status Retensi',
            'Status Validasi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            'A1:G1' => [
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => 'D9EAF7',
                    ],
                ],
            ],

            'A:G' => [
                'alignment' => [
                    'vertical' => 'center',
                ],
            ],
        ];
    }
}
