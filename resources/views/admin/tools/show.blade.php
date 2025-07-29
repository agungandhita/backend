@extends('admin.layouts.main')

@section('title', 'Detail Alat Teknik - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail Alat Teknik</h2>
        <p class="text-muted mb-0">Informasi lengkap alat teknik</p>
    </div>
    <div>
        <a href="{{ route('admin.tools.edit', $tool) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($tool->gambar)
                            <img src="{{ asset('storage/' . $tool->gambar) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $tool->nama }}"
                                 style="max-height: 300px; width: 100%; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                 style="height: 300px;">
                                <i class="fas fa-tools fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="mb-0">{{ $tool->nama }}</h3>
                            <div>
                                @if($tool->is_active)
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>
                                @endif

                            </div>
                        </div>

                        @if($tool->category)
                        <div class="mb-3">
                            <h5 class="text-primary">Kategori</h5>
                            <span class="badge bg-primary fs-6">
                                @if($tool->category->icon)
                                    <i class="{{ $tool->category->icon }} me-1"></i>
                                @endif
                                {{ $tool->category->name }}
                            </span>
                        </div>
                        @endif

                        @if($tool->tags)
                        <div class="mb-3">
                            <h5 class="text-primary">Tags</h5>
                            @foreach(explode(',', $tool->tags) as $tag)
                                <span class="badge bg-light text-dark me-1">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="mb-3">
                            <h5 class="text-primary">Deskripsi</h5>
                            <p class="text-muted">{{ $tool->deskripsi }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-primary">Fungsi</h5>
                            <p class="text-muted">{{ $tool->fungsi }}</p>
                        </div>

                        @if($tool->url_video)
                        <div class="mb-3">
                            <h5 class="text-primary">Video Tutorial</h5>
                            <a href="{{ $tool->url_video }}" target="_blank" class="btn btn-outline-success">
                                <i class="fas fa-play me-2"></i>Tonton Video
                            </a>
                        </div>
                        @endif

                        @if($tool->file_pdf)
                        <div class="mb-3">
                            <h5 class="text-primary">File PDF</h5>
                            <a href="{{ asset('storage/' . $tool->file_pdf) }}" target="_blank" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf me-2"></i>Lihat PDF
                            </a>
                        </div>
                        @endif



                        <div class="mb-3">
                            <h5 class="text-primary">Informasi</h5>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Dibuat:</small><br>
                                    <span>{{ $tool->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Diupdate:</small><br>
                                    <span>{{ $tool->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
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
                    <a href="{{ route('admin.tools.edit', $tool) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Alat
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteTool({{ $tool->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Alat
                    </button>
                    <a href="{{ route('admin.tools.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i>Daftar Alat
                    </a>
                </div>
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
function deleteTool(toolId) {
    if (confirm('Apakah Anda yakin ingin menghapus alat ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/tools/${toolId}`;
        form.submit();
    }
}
</script>
@endpush
