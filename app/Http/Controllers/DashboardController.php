<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArsip = Arsip::count();

        $totalKategori = Kategori::count();

        $totalUser = User::where('role', 'unit pengolah')->count();

        $arsipPending = Arsip::where('status_validasi', 'pending')->count();

        $arsipDiterima = Arsip::where('status_validasi', 'diterima')->count();

        $arsipDitolak = Arsip::where('status_validasi', 'ditolak')->count();

        $arsipPerKategori = Arsip::select(
            'kategori.nama',
            DB::raw('COUNT(arsip.id) as total')
        )
            ->join('kategori', 'kategori.id', '=', 'arsip.id_kategori')
            ->groupBy('kategori.nama')
            ->get();

        $arsipPerBulan = Arsip::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(id) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $arsipTerbaru = Arsip::with(['user', 'kategori'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
            'totalArsip',
            'totalKategori',
            'totalUser',
            'arsipPending',
            'arsipDiterima',
            'arsipDitolak',
            'arsipPerKategori',
            'arsipPerBulan',
            'arsipTerbaru'
        ));
    }
}
