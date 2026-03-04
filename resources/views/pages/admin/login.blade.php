@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px); padding-top: var(--spacing-xl); padding-bottom: var(--spacing-xl);">
    <div class="card w-100" style="max-width: 28rem;">
        <div class="card-header text-center">
            <h2 class="h4 h3-md fw-bold mb-0">Admin Login</h2>
        </div>
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.login.submit') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf
                <div>
                    <label for="login-email" class="form-label">Email</label>
                    <input type="email"
                           class="form-control"
                           id="login-email"
                           name="email"
                           placeholder="admin@email.com"
                           value="{{ old('email') }}"
                           required
                           style="background-color: var(--color-input-background);">
                </div>
                <div>
                    <label for="login-password" class="form-label">Password</label>
                    <input type="password"
                           class="form-control"
                           id="login-password"
                           name="password"
                           placeholder="••••••••"
                           required
                           style="background-color: var(--color-input-background);">
                </div>
                <button type="submit"
                        class="btn btn-success w-100"
                        style="background-color: var(--color-success); border-color: var(--color-success);">
                    Login
                </button>
            </form>
            <div class="mt-4 rounded p-3 small" style="background-color: var(--color-gray-50);">
                <p class="fw-medium mb-1">Demo Admin Account:</p>
                <p class="mb-0">admin@footsy.com / admin123</p>
            </div>
        </div>
    </div>
</div>
@endsection
