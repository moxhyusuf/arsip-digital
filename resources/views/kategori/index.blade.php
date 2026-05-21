@extends('layout.app')

@section('title', 'Kelola Kategori')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Kelola Kategori
                    </h5>

                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        Tambah Kategori
                    </a>
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
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($kategori as $item)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->nama }}
                                        </td>

                                        <td>
                                            {{ $item->keterangan }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2">

                                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="form-delete">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
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

            $('.form-delete').on('submit', function(e) {

                e.preventDefault();

                const form = this;

                if (confirm('Apakah yakin ingin menghapus data kategori ini?')) {
                    form.submit();
                }
            });

        });
    </script>
@endpush
