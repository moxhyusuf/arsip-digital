@extends('layout.app')

@section('title', 'Edit Arsip')

@push('css')
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Edit Arsip
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('arsip.form')

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
