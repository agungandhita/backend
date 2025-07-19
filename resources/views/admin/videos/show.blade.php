@extends('admin.layouts.main')

@section('title', 'Detail Video - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail Video</h2>
        <p class="text-muted mb-0">Informasi lengkap video pembelajaran</p>
    </div>
    <div>
        <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-3">{{ $video->judul }}</h3>

                <!-- YouTube Video Embed -->
                @php
                    $videoId = null;
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp

                @if($videoId)
                <div class="mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                title="{{ $video->judul }}"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @else
                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    URL YouTube tidak valid atau tidak dapat ditampilkan.
                    <br><strong>URL:</strong> <a href="{{ $video->youtube_url }}" target="_blank">{{ $video->youtube_url }}</a>
                </div>
                @endif

                <div class="mb-4">
                    <h5 class="text-primary">Deskripsi</h5>
                    <p class="text-muted">{{ $video->deskripsi }}</p>
                </div>

                <div class="mb-4">
                    <h5 class="text-primary">URL YouTube</h5>
                    <a href="{{ $video->youtube_url }}" target="_blank" class="btn btn-outline-danger">
                        <i class="fab fa-youtube me-2"></i>Buka di YouTube
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary">Informasi</h5>
                        <div class="mb-2">
                            <small class="text-muted">Dibuat:</small><br>
                            <span>{{ $video->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Diupdate:</small><br>
                            <span>{{ $video->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Video
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteVideo({{ $video->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Video
                    </button>
                    <a href="{{ $video->youtube_url }}" target="_blank" class="btn btn-outline-danger">
                        <i class="fab fa-youtube me-2"></i>Buka di YouTube
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i>Daftar Video
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Video</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Judul:</small><br>
                    <strong>{{ $video->judul }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Status URL:</small><br>
                    @if($videoId)
                        <span class="badge bg-success">Valid</span>
                    @else
                        <span class="badge bg-warning">Perlu Dicek</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted">Panjang Deskripsi:</small><br>
                    <span>{{ strlen($video->deskripsi) }} karakter</span>
                </div>

                @if($videoId)
                <div class="mb-3">
                    <small class="text-muted">Video ID:</small><br>
                    <code>{{ $videoId }}</code>
                </div>
                @endif
            </div>
        </div>
    </div>
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
