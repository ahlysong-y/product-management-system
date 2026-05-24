@extends('layouts.profile')

@section('content')
    <div class="container" style="max-width: 1100px;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="fw-bold mb-0">Profile</h2>
                </div>

                <div class="p-4 p-md-5 bg-white shadow rounded-4 mb-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 p-md-5 bg-white shadow rounded-4 mb-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 p-md-5 bg-white shadow rounded-4 mb-4">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
