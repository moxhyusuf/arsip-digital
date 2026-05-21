<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index()
    {
        $id_user = request()->get('id_user', 2);
        $arsip = Arsip::with(['user', 'kategori'])->where('id_user', $id_user)->latest()->get();
        return view('arsip.index', compact('arsip'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('arsip.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'nullable|exists:user,id',
            'id_kategori' => 'required|exists:kategori,id',
            'no_registrasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx',
            'tanggal_retensi' => 'nullable|date',
            'status_retensi' => 'required|in:permanen,sementara',
        ]);

        $validated['id_user'] = Auth::id();
        $validated['file'] = $request->file('file')->store('arsip', 'public');
        Arsip::create($validated);
        return redirect()->route('arsip.index', ['id_user' => Auth::id()])->with('success', 'Data arsip berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        $kategori = Kategori::all();
        return view('arsip.edit', compact('arsip', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $arsip = Arsip::findOrFail($id);

        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'no_registrasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_retensi' => 'nullable|date',
            'status_retensi' => 'required|in:permanen,sementara',
        ]);

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'file|mimes:pdf,doc,docx']);

            if ($arsip->file && Storage::disk('public')->exists($arsip->file)) {
                // Storage::disk('public')->delete($arsip->file); // sementara di-comment untuk menghindari error saat file tidak ditemukan
            }

            $validated['file'] = $request->file('file')->store('arsip', 'public');
        }

        $arsip->update($validated);
        return redirect()->route('arsip.index', ['id_user' => Auth::id()])->with('success', 'Data arsip berhasil diubah');
    }

    public function destroy(string $id)
    {
        $arsip = Arsip::findOrFail($id);

        if ($arsip->file && Storage::disk('public')->exists($arsip->file)) {
            // Storage::disk('public')->delete($arsip->file); // sementara di-comment untuk menghindari error saat file tidak ditemukan
        }

        $arsip->delete();

        return redirect()->back()->with('success', 'Data arsip berhasil dihapus');
    }

    public function validasi(Request $request, string $id)
    {
        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'status_validasi' => 'required|in:diterima,ditolak',
            'pesan_penolakan' => 'nullable|string|max:255',
        ]);

        $arsip->update([
            'status_validasi' => $request->status_validasi,
            'pesan_penolakan' => $request->pesan_penolakan,
        ]);

        return redirect()->back()->with('success', 'Validasi arsip berhasil');
    }
}
