<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Nama
        </label>

        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $kategori->nama ?? '') }}" placeholder="Masukkan nama kategori">

        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Keterangan
        </label>

        <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $kategori->keterangan ?? '') }}" placeholder="Masukkan keterangan">

        @error('keterangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-3">

    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary">
        Simpan
    </button>

</div>
