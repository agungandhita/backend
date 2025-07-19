@extends('admin.layouts.main')

@section('title', 'Tambah Video - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Tambah Video Baru</h2>
        <p class="text-muted mb-0">Tambahkan video pembelajaran baru</p>
    </div>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Video</h5>
            </div>
            <form action="{{ route('admin.videos.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                               id="judul" name="judul" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">URL YouTube <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                               id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}"
                               placeholder="https://www.youtube.com/watch?v=..." required>
                        <div class="form-text">Masukkan URL lengkap video YouTube</div>
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Video
                    </button>
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
                <h5 class="mb-0">Panduan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tips:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Gunakan judul yang menarik dan deskriptif</li>
                        <li>Deskripsi sebaiknya menjelaskan isi video</li>
                        <li>Pastikan URL YouTube valid dan dapat diakses</li>
                        <li>Video sebaiknya berkaitan dengan materi pembelajaran</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Format URL YouTube:</strong><br>
                    <small>
                        • https://www.youtube.com/watch?v=VIDEO_ID<br>
                        • https://youtu.be/VIDEO_ID
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview YouTube video
document.getElementById('youtube_url').addEventListener('input', function() {
    const url = this.value;
    const videoId = extractYouTubeID(url);

    if (videoId) {
        // You can add preview functionality here if needed
        console.log('Valid YouTube URL detected:', videoId);
    }
});

function extractYouTubeID(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}
</script>
@endpush
