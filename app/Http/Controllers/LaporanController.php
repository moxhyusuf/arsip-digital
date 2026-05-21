<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with(['user', 'kategori']);

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        $arsip = $query->latest()->get();

        $kategori = Kategori::all();

        $users = User::where('role', 'unit pengolah')->get();

        return view('laporan.index', compact(
            'arsip',
            'kategori',
            'users'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request),
            'laporan-arsip.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Arsip::with(['user', 'kategori']);

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        $arsip = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('arsip'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-arsip.pdf');
    }
}
