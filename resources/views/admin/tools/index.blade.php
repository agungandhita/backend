@extends('admin.layouts.main')

@section('title', 'Kelola Alat Teknik - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Kelola Alat Teknik</h2>
        <p class="text-muted mb-0">Manajemen data alat-alat teknik</p>
    </div>
    <a href="{{ route('admin.tools.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Alat
    </a>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.tools.index') }}" class="row g-3" id="filter-form">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Alat</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama alat atau fungsi...">
            </div>
            <div class="col-md-2">
                <label for="category" class="form-label">Kategori</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
        </form>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" form="filter-form" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.tools.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Reset
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Grid Alat -->
<div class="row">
    @if($tools->count() > 0)
        @foreach($tools as $tool)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    @if($tool->gambar)
                        <img src="{{ asset('storage/' . $tool->gambar) }}"
                             class="card-img-top"
                             alt="{{ $tool->nama }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="fas fa-tools fa-3x text-muted"></i>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="btn-group-vertical" role="group">
                            <a href="{{ route('admin.tools.show', $tool) }}"
                               class="btn btn-sm btn-info mb-1" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tools.edit', $tool) }}"
                               class="btn btn-sm btn-warning mb-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteTool({{ $tool->id }})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $tool->nama }}</h5>
                        <div>
                            @if($tool->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($tool->category)
                        <div class="mb-2">
                            <span class="badge bg-primary">
                                @if($tool->category->icon)
                                    <i class="{{ $tool->category->icon }} me-1"></i>
                                @endif
                                {{ $tool->category->nama }}
                            </span>
                        </div>
                    @endif
                    
                    <p class="card-text text-muted flex-grow-1">
                        {{ Str::limit($tool->deskripsi, 100) }}
                    </p>

                    <div class="mt-auto">
                        <div class="mb-2">
                            <strong class="text-primary">Fungsi:</strong>
                            <p class="mb-0 small">{{ Str::limit($tool->fungsi, 80) }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                @if($tool->url_video)
                                    <span class="badge bg-success me-1">
                                        <i class="fas fa-video me-1"></i>Video
                                    </span>
                                @endif

                                @if($tool->file_pdf)
                                    <span class="badge bg-danger me-1">
                                        <i class="fas fa-file-pdf me-1"></i>PDF
                                    </span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ $tool->views_count ?? 0 }} views
                            </small>
                        </div>

                        @if($tool->tags)
                            <div class="mb-2">
                                @foreach(explode(',', $tool->tags) as $tag)
                                    <span class="badge bg-light text-dark me-1">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="text-muted small">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $tool->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $tools->firstItem() }} - {{ $tools->lastItem() }} dari {{ $tools->total() }} alat
                </div>
                {{ $tools->links() }}
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada alat ditemukan</h5>
                    <p class="text-muted">Belum ada data alat teknik atau sesuaikan filter pencarian</p>
                    <a href="{{ route('admin.tools.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Alat Pertama
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Form Delete (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteTool(toolId) {
    if (confirm('Apakah Anda yakin ingin menghapus alat ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/tools/${toolId}`;
        form.submit();
    }
}
</script>
@endpush
