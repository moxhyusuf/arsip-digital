@extends('layout.app')

@section('title', 'Edit User')

@push('css')
@endpush

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">
                        Edit User
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @include('user.form')

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
@endpush
