@extends('admin.layouts.main')

@section('title', 'Edit Video - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Edit Video</h2>
        <p class="text-muted mb-0">Ubah informasi video pembelajaran</p>
    </div>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Video</h5>
            </div>
            <form action="{{ route('admin.videos.update', $video) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul', $video->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $video->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">URL YouTube <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                               id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}"
                               placeholder="https://www.youtube.com/watch?v=..." required>
                        <div class="form-text">Masukkan URL lengkap video YouTube</div>
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preview Video -->
                    <div class="mb-3">
                        <label class="form-label">Preview Video Saat Ini</label>
                        @php
                            $videoId = null;
                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video->youtube_url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp

                        @if($videoId)
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                    title="{{ $video->judul }}"
                                    allowfullscreen>
                            </iframe>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            URL YouTube saat ini tidak valid atau tidak dapat ditampilkan.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Video
                    </button>
                    <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi Video</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Judul Saat Ini:</small><br>
                    <strong>{{ $video->judul }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Dibuat:</small><br>
                    <span>{{ $video->created_at->format('d M Y H:i') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Terakhir diupdate:</small><br>
                    <span>{{ $video->updated_at->format('d M Y H:i') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">URL Saat Ini:</small><br>
                    <a href="{{ $video->youtube_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                        <i class="fab fa-youtube me-1"></i>Buka
                    </a>
                </div>

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tips:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Pastikan URL YouTube valid</li>
                        <li>Video sebaiknya dapat diakses publik</li>
                        <li>Gunakan judul yang menarik</li>
                        <li>Deskripsi yang jelas membantu pemahaman</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Format URL YouTube</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Format yang didukung:</strong><br>
                    <small>
                        • https://www.youtube.com/watch?v=VIDEO_ID<br>
                        • https://youtu.be/VIDEO_ID<br>
                        • https://m.youtube.com/watch?v=VIDEO_ID
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview YouTube video on URL change
document.getElementById('youtube_url').addEventListener('input', function() {
    const url = this.value;
    const videoId = extractYouTubeID(url);

    if (videoId) {
        console.log('Valid YouTube URL detected:', videoId);
        // You can add real-time preview functionality here if needed
    }
});

function extractYouTubeID(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}
</script>
@endpush
