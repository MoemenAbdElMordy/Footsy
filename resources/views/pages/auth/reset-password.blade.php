@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <div class="card w-100" style="max-width: 28rem;">
        <div class="card-header text-center">
            <h2 class="h5 fw-bold mb-0">Enter Reset Code</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('password.reset_code') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf

                <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">

                <div>
                    <label for="code" class="form-label">Reset Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required maxlength="6" style="background-color: var(--color-input-background);">
                    @error('code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="6" style="background-color: var(--color-input-background);">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="6" style="background-color: var(--color-input-background);">
                </div>

                <button type="submit" class="btn btn-success w-100" style="background-color: var(--color-success); border-color: var(--color-success);">
                    Reset Password
                </button>

                <div class="text-center">
                    <a href="{{ route('password.forgot') }}" class="small text-decoration-none">Resend code</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
