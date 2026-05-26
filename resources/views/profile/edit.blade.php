@extends('layouts.profile')

@section('content')
<div class="container" style="max-width: 1100px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Profile Information Card -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Profile" class="rounded-circle border" style="width: 100px; height: 100px;">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label kib for="profile_image" class="form-label fw-bold">Profile Image</label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">Role</label>
                                <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role ?? 'User') }}" disabled>
                                <small class="text-muted">Role cannot be changed</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="profile_code" class="form-label fw-bold">Profile Code</label>
                                <input type="text" class="form-control" id="profile_code" value="{{ $user->profile_code ?? 'N/A' }}" disabled>
                                <small class="text-muted">Auto-generated code</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Profile
                            </button>
                            @if (session('status') === 'profile-updated')
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill"></i> Profile updated successfully!
                            </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-warning text-dark rounded-top-4">
                    <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Change Password</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label fw-bold">Current Password</label>
                                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">New Password</label>
                                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" required>
                                @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-3">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key"></i> Change Password
                            </button>
                            @if (session('status') === 'password-updated')
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill"></i> Password changed successfully!
                            </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card shadow-sm rounded-4 mb-4 border-danger">
                <div class="card-header bg-danger text-white rounded-top-4">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Danger Zone</h5>
                </div>
                <div class="card-body p-4">
                    <h6 class="fw-bold">Delete Account</h6>
                    <p class="text-muted mb-3">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Account Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted.
                        Please enter your password to confirm you would like to permanently delete your account.</p>

                    <div class="mb-3">
                        <label for="delete_password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="delete_password" name="password" placeholder="Enter your password" required>
                        @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        modal.show();
    });

</script>
@endif
@endsection
