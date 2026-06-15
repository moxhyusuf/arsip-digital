@extends('layout.app')

@section('title', 'Laporan')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Filter Laporan
                    </h5>
                </div>

                <div class="card-body">

                    <form method="GET">

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Tanggal Awal
                                </label>

                                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Tanggal Akhir
                                </label>

                                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Kategori
                                </label>

                                <select name="id_kategori" class="form-select">
                                    <option value="">
                                        Semua Kategori
                                    </option>

                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}" @selected(request('id_kategori') == $item->id)>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Unit Pengolah
                                </label>

                                <select name="id_user" class="form-select">
                                    <option value="">
                                        Semua Unit
                                    </option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(request('id_user') == $user->id)>
                                            {{ $user->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>

                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                            <a href="{{ route('laporan.export.excel', request()->query()) }}" class="btn btn-success">
                                Export Excel
                            </a>

                            <a href="{{ route('laporan.export.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                                Export PDF
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Data Laporan Arsip
                    </h5>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped" id="datatable">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Unit Pengolah</th>
                                    <th>Kategori</th>
                                    <th>Nama Arsip</th>
                                    <th>Status Retensi</th>
                                    <th>Status Validasi</th>
                                    <th>File</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($arsip as $item)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            {{ $item->kode }}
                                        </td>

                                        <td>
                                            {{ $item->user->nama }}
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
                                            <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-info btn-sm">
                                                File
                                            </a>
                                        </td>

                                    </tr>
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

        });
    </script>
@endpush
