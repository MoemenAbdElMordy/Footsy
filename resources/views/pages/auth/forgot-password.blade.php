@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <div class="card w-100" style="max-width: 28rem;">
        <div class="card-header text-center">
            <h2 class="h5 fw-bold mb-0">Reset Password</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('password.email_code') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required style="background-color: var(--color-input-background);">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100" style="background-color: var(--color-success); border-color: var(--color-success);">
                    Send Reset Code
                </button>

                <a href="{{ route('login') }}" class="text-center small text-decoration-none">Back to login</a>
            </form>
        </div>
    </div>
</div>
@endsection
