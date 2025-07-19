@extends('admin.layouts.main')

@section('title', 'Kelola Video Pembelajaran - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Kelola Video Pembelajaran</h2>
        <p class="text-muted mb-0">Manajemen video pembelajaran teknik</p>
    </div>
    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Video
    </a>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.videos.index') }}" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Cari Video</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Judul atau deskripsi video...">
            </div>
            <div class="col-md-4">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="judul_asc" {{ request('sort') == 'judul_asc' ? 'selected' : '' }}>Judul A-Z</option>
                    <option value="judul_desc" {{ request('sort') == 'judul_desc' ? 'selected' : '' }}>Judul Z-A</option>
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

<!-- Grid Video -->
<div class="row">
    @if($videos->count() > 0)
        @foreach($videos as $video)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    @php
                        // Extract YouTube ID from URL
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->youtube_url, $matches);
                        $youtube_id = $matches[1] ?? null;
                        $thumbnail = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/maxresdefault.jpg" : null;
                    @endphp

                    @if($thumbnail)
                        <img src="{{ $thumbnail }}"
                             class="card-img-top"
                             alt="{{ $video->judul }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="fas fa-video fa-3x text-muted"></i>
                        </div>
                    @endif

                    <!-- Play Button Overlay -->
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <a href="{{ $video->youtube_url }}" target="_blank"
                           class="btn btn-danger btn-lg rounded-circle"
                           style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-play" style="margin-left: 3px;"></i>
                        </a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="btn-group-vertical" role="group">
                            <a href="{{ route('admin.videos.show', $video) }}"
                               class="btn btn-sm btn-info mb-1" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.videos.edit', $video) }}"
                               class="btn btn-sm btn-warning mb-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteVideo({{ $video->id }})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $video->judul }}</h5>
                    <p class="card-text text-muted flex-grow-1">
                        {{ Str::limit($video->deskripsi, 120) }}
                    </p>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center text-danger">
                                <i class="fab fa-youtube me-2"></i>
                                <small>YouTube</small>
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $video->created_at->format('d M Y') }}
                            </div>
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
                    Menampilkan {{ $videos->firstItem() }} - {{ $videos->lastItem() }} dari {{ $videos->total() }} video
                </div>
                {{ $videos->links() }}
            </div>
        </div>
    @else
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada video ditemukan</h5>
                    <p class="text-muted">Belum ada data video pembelajaran atau sesuaikan filter pencarian</p>
                    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Video Pertama
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
function deleteVideo(videoId) {
    if (confirm('Apakah Anda yakin ingin menghapus video ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/videos/${videoId}`;
        form.submit();
    }
}
</script>
@endpush
