<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Kode Arsip
        </label>

        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $arsip->kode ?? '') }}" placeholder="Masukkan kode arsip">

        @error('kode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $item)
                @if (isset($arsip->id) && $item->nama === 'SPJ')
                    @continue
                @endif
                <option value="{{ $item->id }}" @selected(old('id_kategori', $arsip->id_kategori ?? '') == $item->id)>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>
        @error('id_kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Nama Arsip
        </label>

        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $arsip->nama ?? '') }}" placeholder="Masukkan nama arsip">

        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Status Retensi
        </label>

        <select name="status_retensi" class="form-select @error('status_retensi') is-invalid @enderror">
            <option value="">
                -- Pilih Status --
            </option>

            <option value="permanen" @selected(old('status_retensi', $arsip->status_retensi ?? '') == 'permanen')>
                Permanen
            </option>

            <option value="sementara" @selected(old('status_retensi', $arsip->status_retensi ?? '') == 'sementara')>
                Sementara
            </option>

            <option value="dimusnahkan (Srikandi)" @selected(old('status_retensi', $arsip->status_retensi ?? '') == 'dimusnahkan (Srikandi)')>
                Dimusnahkan (Srikandi)
            </option>
        </select>

        @error('status_retensi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Tanggal Retensi
        </label>

        <input type="date" name="tanggal_retensi" class="form-control @error('tanggal_retensi') is-invalid @enderror" value="{{ old('tanggal_retensi', isset($arsip) && $arsip->tanggal_retensi ? $arsip->tanggal_retensi->format('Y-m-d') : '') }}">

        @error('tanggal_retensi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            File
        </label>

        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="application/pdf">

        @error('file')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">
            Deskripsi
        </label>

        <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Masukkan deskripsi">{{ old('deskripsi', $arsip->deskripsi ?? '') }}</textarea>

        @error('deskripsi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3" id="passphrase-field" style="display:none;">
        <label class="form-label">
            Passphrase Enkripsi File (khusus SPJ)
        </label>

        <input type="password" name="passphrase" class="form-control @error('passphrase') is-invalid @enderror" placeholder="Masukkan passphrase untuk enkripsi file">

        <small class="text-muted">Wajib diingat — passphrase ini diperlukan untuk membuka file nanti. (Min 6 karakter)</small>

        @error('passphrase')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-3">

    <a href="{{ route('arsip.index') }}" class="btn btn-secondary">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary">
        Simpan
    </button>

</div>


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.querySelector('select[name="id_kategori"]');
            const passField = document.getElementById('passphrase-field');

            const spjOptions = Array.from(kategoriSelect.options)
                .filter(opt => opt.text.trim().toLowerCase() === 'spj')
                .map(opt => opt.value);

            function toggleField() {
                passField.style.display = spjOptions.includes(kategoriSelect.value) ? 'block' : 'none';
            }

            kategoriSelect.addEventListener('change', toggleField);
            toggleField();
        });
    </script>
@endpush
