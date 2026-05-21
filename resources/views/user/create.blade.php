@extends('layout.app')

@section('title', 'Tambah User')

@push('css')
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Tambah User
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        @include('user.form')

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
