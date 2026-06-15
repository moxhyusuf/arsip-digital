@extends('layout.app')

@section('title', 'Kelola Arsip')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Kelola Arsip
                    </h5>

                    @if (Auth::user()->role == 'unit pengolah')
                        <a href="{{ route('arsip.create') }}" class="btn btn-primary">
                            Tambah Arsip
                        </a>
                    @endif
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Arsip</th>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Status Retensi</th>
                                    <th>Status Validasi</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($arsip as $item)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->kode }}
                                        </td>

                                        <td>
                                            {{ $item->kategori->nama }}
                                        </td>

                                        <td>
                                            {{ $item->nama }}
                                        </td>

                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst($item->status_retensi) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($item->status_validasi == 'pending')
                                                <span class="badge bg-warning">
                                                    Pending
                                                </span>
                                            @elseif ($item->status_validasi == 'diterima')
                                                <span class="badge bg-success">
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">

                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-info btn-sm">
                                                    File
                                                </a>

                                                @if (Auth::user()->role == 'admin')
                                                    @if ($item->status_validasi == 'pending')
                                                        <form action="{{ route('arsip.validasi', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status_validasi" value="diterima">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                Terima
                                                            </button>
                                                        </form>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $item->id }}">
                                                            Tolak
                                                        </button>
                                                    @endif


                                                    @if ($item->status_validasi == 'diterima')
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $item->id }}">
                                                            Tolak
                                                        </button>
                                                    @endif
                                                @endif

                                                @if ($item->status_validasi == 'ditolak')
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPesan{{ $item->id }}">
                                                        Pesan
                                                    </button>

                                                    @if (Auth::user()->role == 'admin')
                                                        <form action="{{ route('arsip.validasi', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status_validasi" value="diterima">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                Terima
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif

                                                @if ($item->status_validasi != 'diterima')
                                                    @if (Auth::user()->role == 'unit pengolah')
                                                        @if ($item->kategori->nama != 'SPJ')
                                                            <a href="{{ route('arsip.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                                Edit
                                                            </a>
                                                        @endif

                                                        <form action="{{ route('arsip.destroy', $item->id) }}" method="POST" class="form-delete">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                    <div class="modal fade" id="modalTolak{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('arsip.validasi', $item->id) }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="status_validasi" value="ditolak">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Pesan Penolakan
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div class="mb-3">
                                                            <label class="form-label">
                                                                Pesan Penolakan
                                                            </label>

                                                            <textarea name="pesan_penolakan" rows="5" class="form-control" required></textarea>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Batal
                                                        </button>

                                                        <button type="submit" class="btn btn-danger">
                                                            Tolak Arsip
                                                        </button>

                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    @if ($item->status_validasi == 'ditolak')
                                        <div class="modal fade" id="modalPesan{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Pesan Penolakan
                                                        </h5>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        {{ $item->pesan_penolakan }}

                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Tutup
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#datatable').DataTable();

            $('.form-delete').on('submit', function(e) {

                e.preventDefault();

                const form = this;

                if (confirm('Apakah yakin ingin menghapus data arsip ini?')) {
                    form.submit();
                }
            });

        });
    </script>
@endpush
