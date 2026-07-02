<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\User;
use App\Services\PdfEncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $kategoriModel = Kategori::find($request->id_kategori);
        $isSpj = $kategoriModel && strtolower($kategoriModel->nama) === 'spj';

        $validated = $request->validate([
            'id_user' => 'nullable|exists:user,id',
            'id_kategori' => 'required|exists:kategori,id',
            'kode' => 'required|string|max:255|unique:arsip,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => ['required', 'file', $isSpj ? 'mimes:pdf' : 'mimes:pdf,doc,docx'],
            'tanggal_retensi' => 'nullable|date',
            'status_retensi' => 'required|in:permanen,sementara,dimusnahkan (Srikandi)',
            'passphrase' => [Rule::requiredIf($isSpj), 'string', 'nullable', 'min:6'],
        ]);

        $validated['id_user'] = Auth::id();
        $path = $request->file('file')->store('arsip', 'public');
        $validated['file'] = $path;

        if ($isSpj) {
            $absolutePath = Storage::disk('public')->path($path);
            app(PdfEncryptionService::class)->encrypt($absolutePath, $validated['passphrase']);
            $validated['is_encrypted'] = true;
        }

        unset($validated['passphrase']);

        Arsip::create($validated);
        return redirect()->route('arsip.index', ['id_user' => Auth::id()])->with('success', 'Data arsip berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        if ($arsip->kategori && $arsip->kategori->nama === 'SPJ') {
            return redirect()->route('arsip.index')->with('error', 'Arsip dengan kategori SPJ tidak dapat diubah.');
        }
        $kategori = Kategori::all();
        return view('arsip.edit', compact('arsip', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $arsip = Arsip::findOrFail($id);

        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_retensi' => 'nullable|date',
            'status_retensi' => 'required|in:permanen,sementara,dimusnahkan (Srikandi)',
        ]);

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'file|mimes:pdf,doc,docx']);

            if ($arsip->file && Storage::disk('public')->exists($arsip->file)) {
                Storage::disk('public')->delete($arsip->file);
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
            Storage::disk('public')->delete($arsip->file);
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
