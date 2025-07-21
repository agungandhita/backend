@extends('admin.layouts.main')

@section('title', 'Kelola Kategori - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Kelola Kategori</h2>
        <p class="text-muted mb-0">Manajemen kategori alat teknik</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
            <div class="col-md-8">
                <label for="search" class="form-label">Cari Kategori</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama kategori atau deskripsi...">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Kategori -->
<div class="card shadow-sm">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Icon</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Alat</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                @if($category->icon)
                                    <i class="{{ $category->icon }} fa-lg text-primary"></i>
                                @else
                                    <i class="fas fa-folder fa-lg text-muted"></i>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $category->nama }}</strong>
                            </td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>
                                {{ Str::limit($category->deskripsi, 80) }}
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $category->tools_count }} alat</span>
                            </td>
                            <td>
                                {{ $category->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}"
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteCategory({{ $category->id }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                </div>
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada kategori ditemukan</h5>
                <p class="text-muted">Belum ada data kategori atau sesuaikan pencarian</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
                </a>
            </div>
        @endif
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
function deleteCategory(categoryId) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini? Kategori yang memiliki alat tidak dapat dihapus.')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/categories/${categoryId}`;
        form.submit();
    }
}
</script>
@endpush