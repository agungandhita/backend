@extends('admin.layouts.main')

@section('title', 'Edit Kategori - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Edit Kategori</h2>
        <p class="text-muted mb-0">Ubah informasi kategori: {{ $category->nama }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kategori</h5>
            </div>
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama', $category->nama) }}" required
                               placeholder="Masukkan nama kategori">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama kategori akan otomatis diubah menjadi slug</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" required
                                  placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon (Opsional)</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                               placeholder="Contoh: fas fa-tools">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Gunakan class FontAwesome. Contoh: <code>fas fa-tools</code>, <code>fas fa-wrench</code>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Slug saat ini:</strong> <code>{{ $category->slug }}</code>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Preview Icon</h6>
            </div>
            <div class="card-body text-center">
                <div id="icon-preview" class="mb-3">
                    @if($category->icon)
                        <i class="{{ $category->icon }} fa-3x text-primary"></i>
                    @else
                        <i class="fas fa-folder fa-3x text-muted"></i>
                    @endif
                </div>
                <small class="text-muted">Icon akan muncul di sini saat Anda mengetik</small>
            </div>
        </div>
        
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Statistik Kategori</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary mb-1">{{ $category->tools()->count() }}</h4>
                        <small class="text-muted">Total Alat</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1">{{ $category->tools()->where('is_active', true)->count() }}</h4>
                        <small class="text-muted">Alat Aktif</small>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <small class="text-muted">
                        Dibuat: {{ $category->created_at->format('d M Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Contoh Icon</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 text-center">
                        <i class="fas fa-tools fa-2x text-primary mb-2"></i>
                        <br><small><code>fas fa-tools</code></small>
                    </div>
                    <div class="col-6 text-center">
                        <i class="fas fa-wrench fa-2x text-success mb-2"></i>
                        <br><small><code>fas fa-wrench</code></small>
                    </div>
                    <div class="col-6 text-center">
                        <i class="fas fa-hammer fa-2x text-warning mb-2"></i>
                        <br><small><code>fas fa-hammer</code></small>
                    </div>
                    <div class="col-6 text-center">
                        <i class="fas fa-cogs fa-2x text-info mb-2"></i>
                        <br><small><code>fas fa-cogs</code></small>
                    </div>
                    <div class="col-6 text-center">
                        <i class="fas fa-screwdriver fa-2x text-danger mb-2"></i>
                        <br><small><code>fas fa-screwdriver</code></small>
                    </div>
                    <div class="col-6 text-center">
                        <i class="fas fa-ruler fa-2x text-secondary mb-2"></i>
                        <br><small><code>fas fa-ruler</code></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value.trim();
    const preview = document.getElementById('icon-preview');
    
    if (iconClass) {
        preview.innerHTML = `<i class="${iconClass} fa-3x text-primary"></i>`;
    } else {
        preview.innerHTML = '<i class="fas fa-folder fa-3x text-muted"></i>';
    }
});
</script>
@endpush