@extends('admin.layouts.main')

@section('title', 'Edit Alat Teknik - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Edit Alat Teknik</h2>
        <p class="text-muted mb-0">Ubah informasi alat teknik</p>
    </div>
    <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Alat</h5>
            </div>
            <form action="{{ route('admin.tools.update', $tool) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Alat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               id="nama" name="nama" value="{{ old('nama', $tool->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $tool->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fungsi" class="form-label">Fungsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('fungsi') is-invalid @enderror"
                                  id="fungsi" name="fungsi" rows="3" required>{{ old('fungsi', $tool->fungsi) }}</textarea>
                        @error('fungsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        @if($tool->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tool->gambar) }}"
                                     alt="{{ $tool->nama }}"
                                     class="img-thumbnail"
                                     style="max-height: 150px;">
                                <p class="text-muted small mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                               id="gambar" name="gambar" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar</div>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="url_video" class="form-label">URL Video (Opsional)</label>
                        <input type="url" class="form-control @error('url_video') is-invalid @enderror"
                               id="url_video" name="url_video" value="{{ old('url_video', $tool->url_video) }}">
                        @error('url_video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label">File PDF</label>
                        @if($tool->file_pdf)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $tool->file_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-2"></i>Lihat PDF Saat Ini
                                </a>
                                <p class="text-muted small mt-1">File PDF saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('file_pdf') is-invalid @enderror"
                               id="file_pdf" name="file_pdf" accept=".pdf">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah file PDF. Maksimal ukuran: 10MB</div>
                        @error('file_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Alat
                    </button>
                    <a href="{{ route('admin.tools.show', $tool) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Dibuat:</small><br>
                    <span>{{ $tool->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Terakhir diupdate:</small><br>
                    <span>{{ $tool->updated_at->format('d M Y H:i') }}</span>
                </div>
                <hr>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tips:</strong> Pastikan gambar yang diupload memiliki kualitas yang baik dan ukuran yang sesuai.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
