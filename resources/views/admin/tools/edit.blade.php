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
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $tool->category_id) == $category->id ? 'selected' : '' }}>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} me-2"></i>
                                    @endif
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (Opsional)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                               id="tags" name="tags" value="{{ old('tags', $tool->tags) }}"
                               placeholder="Contoh: bor, listrik, portable">
                        <div class="form-text">Pisahkan dengan koma untuk multiple tags</div>
                        @error('tags')
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                           {{ old('is_featured', $tool->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i>Alat Unggulan
                                    </label>
                                </div>
                                <div class="form-text">Tampilkan di daftar alat unggulan</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', $tool->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fas fa-check-circle text-success me-1"></i>Status Aktif
                                    </label>
                                </div>
                                <div class="form-text">Alat dapat dilihat oleh pengguna</div>
                            </div>
                        </div>
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
                <h5 class="mb-0">Informasi Alat</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Status:</small><br>
                    @if($tool->is_active)
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                    @else
                        <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>
                    @endif
                    @if($tool->is_featured)
                        <span class="badge bg-warning text-dark ms-1"><i class="fas fa-star me-1"></i>Unggulan</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Kategori:</small><br>
                    @if($tool->category)
                        <span class="badge bg-primary">
                            @if($tool->category->icon)
                                <i class="{{ $tool->category->icon }} me-1"></i>
                            @endif
                            {{ $tool->category->name }}
                        </span>
                    @else
                        <span class="text-muted">Belum dikategorikan</span>
                    @endif
                </div>

                @if($tool->tags)
                    <div class="mb-3">
                        <small class="text-muted">Tags:</small><br>
                        @foreach(explode(',', $tool->tags) as $tag)
                            <span class="badge bg-light text-dark me-1">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="row text-center mb-3">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="h5 mb-0 text-primary">{{ number_format($tool->views_count ?? 0) }}</div>
                            <small class="text-muted">Views</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <div class="h5 mb-0 text-danger">{{ $tool->favorites_count ?? 0 }}</div>
                            <small class="text-muted">Favorites</small>
                        </div>
                    </div>
                </div>

                <hr>
                
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
                    <strong>Tips:</strong> Pastikan semua field terisi dengan benar dan pilih kategori yang sesuai.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
