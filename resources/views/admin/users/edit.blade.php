@extends('admin.layouts.main')

@section('title', 'Edit User - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Edit User</h2>
        <p class="text-muted mb-0">Ubah informasi user</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Edit User</h5>
            </div>
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah password</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                               id="kelas" name="kelas" value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XII RPL 1">
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Profil</label>
                        @if($user->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->foto) }}"
                                     alt="{{ $user->name }}"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                                <p class="text-muted small mt-1">Foto saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, GIF. Maksimal 2MB</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi User</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}"
                             alt="{{ $user->name }}"
                             class="img-fluid rounded-circle"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mx-auto"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-muted"></i>
                        </div>
                    @endif
                    <h6 class="mt-2">{{ $user->name }}</h6>
                    @if($user->kelas)
                        <span class="badge bg-primary">{{ $user->kelas }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted">Bergabung:</small><br>
                    <span>{{ $user->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Terakhir diupdate:</small><br>
                    <span>{{ $user->updated_at->format('d M Y H:i') }}</span>
                </div>

                @if($user->scores->count() > 0)
                <div class="mb-3">
                    <small class="text-muted">Total Quiz:</small><br>
                    <span class="badge bg-success">{{ $user->scores->count() }} attempt</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Rata-rata Skor:</small><br>
                    <span class="badge bg-info">{{ number_format($user->scores->avg('skor'), 1) }}</span>
                </div>
                @endif

                <hr>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> Perubahan email dan password akan mempengaruhi login user.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
