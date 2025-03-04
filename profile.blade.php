@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle"></i> Edit Profile</h5>
                </div>

                <div class="card-body p-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center p-2" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show p-2" role="alert">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li><i class="bi bi-exclamation-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-2">
                            <label for="name" class="form-label fw-bold small"><i class="bi bi-person"></i> Name</label>
                            <input type="text" class="form-control form-control-sm shadow-sm" id="name" name="name" 
                                   value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label fw-bold small"><i class="bi bi-envelope"></i> Email</label>
                            <input type="email" class="form-control form-control-sm shadow-sm" id="email" name="email" 
                                   value="{{ auth()->user()->email }}" required>
                        </div>

                        <hr>

                        <div class="mb-2">
                            <label for="current_password" class="form-label fw-bold small">
                                <i class="bi bi-lock"></i> Current Password <small class="text-muted">(Required for Change)</small>
                            </label>
                            <input type="password" class="form-control form-control-sm shadow-sm" id="current_password" 
                                   name="current_password">
                        </div>

                        <div class="mb-2">
                            <label for="new_password" class="form-label fw-bold small"><i class="bi bi-key"></i> New Password</label>
                            <input type="password" class="form-control form-control-sm shadow-sm" id="new_password" 
                                   name="new_password" minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold small">
                                <i class="bi bi-check-lg"></i> Confirm New Password
                            </label>
                            <input type="password" class="form-control form-control-sm shadow-sm" id="new_password_confirmation" 
                                   name="new_password_confirmation">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-gradient btn-sm shadow-sm rounded-pill">
                                <i class="bi bi-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-gradient {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
        border: none;
        font-size: 14px;
        padding: 8px 12px;
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, #0056b3, #003580);
    }
    .shadow-sm {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
    }
    .rounded-pill {
        border-radius: 50px !important;
    }
</style>
@endsection
