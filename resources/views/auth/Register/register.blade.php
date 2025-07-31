@extends('auth.layouts.main')

@section('title', 'Register')

@section('container')
<div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-4">
            <div class="auth-card p-5">
                <!-- Logo and Title -->
                <div class="text-center mb-4">
                    <div class="logo-container">
                        <img src="{{ asset('img/logo.jpeg') }}" alt="E-Jarkom Surabaya Logo" class="img-fluid">
                    </div>
                    <h2 class="fw-bold text-dark mb-2">Admin E-Jarkom</h2>
                    <p class="text-muted mb-0">Daftar akun baru</p>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Register Form -->
                <form action="{{ route('register.post') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input type="text"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama') }}"
                                   placeholder="Masukkan nama lengkap Anda"
                                   required>
                        </div>
                        @error('nama')
                            <div class="invalid-feedback d-block">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Masukkan email Anda"
                                   required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group position-relative">
                            <span class="input-group-text">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password (min. 8 karakter)"
                                   required>
                            <span class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <div class="form-text">
                            <small class="text-muted">Password minimal 8 karakter</small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Daftar Akun
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-muted mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                            Masuk disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
