@extends('admin.layouts.main')

@section('title', 'Detail Kategori - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail Kategori</h2>
        <p class="text-muted mb-0">Informasi lengkap kategori: {{ $category->nama }}</p>
    </div>
    <div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Informasi Kategori -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kategori</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($category->icon)
                        <i class="{{ $category->icon }} fa-4x text-primary"></i>
                    @else
                        <i class="fas fa-folder fa-4x text-muted"></i>
                    @endif
                </div>
                <h4 class="mb-2">{{ $category->nama }}</h4>
                <p class="text-muted mb-3">{{ $category->deskripsi }}</p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h3 class="text-primary mb-1">{{ $category->tools->count() }}</h3>
                        <small class="text-muted">Total Alat</small>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success mb-1">{{ $category->tools->where('is_active', true)->count() }}</h3>
                        <small class="text-muted">Alat Aktif</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detail Teknis -->
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Detail Teknis</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Slug:</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>Icon Class:</strong></td>
                        <td>
                            @if($category->icon)
                                <code>{{ $category->icon }}</code>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate:</strong></td>
                        <td>{{ $category->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Daftar Alat dalam Kategori -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Alat dalam Kategori</h5>
                <a href="{{ route('admin.tools.create') }}?category={{ $category->id }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Alat
                </a>
            </div>
            <div class="card-body">
                @if($category->tools->count() > 0)
                    <div class="row">
                        @foreach($category->tools as $tool)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="row g-0">
                                    <div class="col-4">
                                        @if($tool->gambar)
                                            <img src="{{ asset('storage/' . $tool->gambar) }}"
                                                 class="img-fluid rounded-start h-100"
                                                 alt="{{ $tool->nama }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                                <i class="fas fa-tools fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-2">{{ $tool->nama }}</h6>
                                            <p class="card-text small text-muted mb-2">
                                                {{ Str::limit($tool->deskripsi, 60) }}
                                            </p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    @if($tool->is_featured)
                                                        <span class="badge bg-warning text-dark">Featured</span>
                                                    @endif
                                                    @if($tool->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Nonaktif</span>
                                                    @endif
                                                </div>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.tools.show', $tool) }}" 
                                                       class="btn btn-outline-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.tools.edit', $tool) }}" 
                                                       class="btn btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>{{ $tool->views_count }} views
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($category->tools->count() > 10)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.tools.index') }}?category={{ $category->id }}" class="btn btn-outline-primary">
                                Lihat Semua Alat ({{ $category->tools->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada alat dalam kategori ini</h6>
                        <p class="text-muted mb-3">Mulai tambahkan alat untuk kategori {{ $category->nama }}</p>
                        <a href="{{ route('admin.tools.create') }}?category={{ $category->id }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Alat Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection