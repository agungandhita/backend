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
        <form method="GET" action="{{ route('admin.tools.index') }}" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Cari Alat</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama alat atau fungsi...">
            </div>
            <div class="col-md-4">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
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
                    <h5 class="card-title">{{ $tool->nama }}</h5>
                    <p class="card-text text-muted flex-grow-1">
                        {{ Str::limit($tool->deskripsi, 100) }}
                    </p>

                    <div class="mt-auto">
                        <div class="mb-2">
                            <strong class="text-primary">Fungsi:</strong>
                            <p class="mb-0 small">{{ Str::limit($tool->fungsi, 80) }}</p>
                        </div>

                        @if($tool->url_video)
                            <div class="d-flex align-items-center text-success mb-2">
                                <i class="fas fa-video me-2"></i>
                                <small>Video tersedia</small>
                            </div>
                        @endif

                        @if($tool->file_pdf)
                            <div class="d-flex align-items-center text-danger mb-2">
                                <i class="fas fa-file-pdf me-2"></i>
                                <small>PDF tersedia</small>
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
