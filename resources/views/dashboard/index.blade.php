@extends('layout.app')

@section('title', 'Dashboard')

@push('css')
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="row">

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="mb-2 text-muted">
                                Total Arsip
                            </h6>

                            <h3 class="mb-0">
                                {{ $totalArsip }}
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="mb-2 text-muted">
                                Total Kategori
                            </h6>

                            <h3 class="mb-0">
                                {{ $totalKategori }}
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="mb-2 text-muted">
                                Unit Pengolah
                            </h6>

                            <h3 class="mb-0">
                                {{ $totalUser }}
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="mb-2 text-muted">
                                Arsip Pending
                            </h6>

                            <h3 class="mb-0">
                                {{ $arsipPending }}
                            </h3>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                Status Validasi
                            </h5>
                        </div>

                        <div class="card-body">
                            <div id="chart-validasi"></div>
                        </div>

                    </div>

                </div>

                <div class="col-md-8">

                    <div class="card h-100">

                        <div class="card-header">
                            <h5 class="mb-0">
                                Statistik Kategori Arsip
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                @foreach ($arsipPerKategori as $item)
                                    <div class="col-md-4 mb-3">

                                        <div class="border rounded p-3 h-100">

                                            <h6 class="mb-2 text-muted">
                                                {{ $item->nama }}
                                            </h6>

                                            <h2 class="mb-0">
                                                {{ $item->total }}
                                            </h2>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">
                            <h5 class="mb-0">
                                Arsip Terbaru
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered">

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Registrasi</th>
                                            <th>Unit Pengolah</th>
                                            <th>Kategori</th>
                                            <th>Nama Arsip</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($arsipTerbaru as $item)
                                            <tr>

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>
                                                    {{ $item->no_registrasi }}
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

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        const chartValidasi = new ApexCharts(
            document.querySelector("#chart-validasi"), {
                chart: {
                    type: 'donut',
                    height: 350
                },

                series: [
                    {{ $arsipPending }},
                    {{ $arsipDiterima }},
                    {{ $arsipDitolak }}
                ],

                labels: [
                    'Pending',
                    'Diterima',
                    'Ditolak'
                ]
            }
        );

        chartValidasi.render();
    </script>
@endpush
