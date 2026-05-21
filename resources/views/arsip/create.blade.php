@extends('layout.app')

@section('title', 'Tambah Arsip')

@push('css')
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Tambah Arsip
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('arsip.form')

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
