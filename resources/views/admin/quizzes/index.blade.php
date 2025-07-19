@extends('admin.layouts.main')

@section('title', 'Kelola Quiz - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Kelola Quiz</h2>
        <p class="text-muted mb-0">Manajemen soal quiz berdasarkan level kesulitan</p>
    </div>
    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Quiz
    </a>
</div>

<!-- Statistik Level -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Quiz Mudah
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['mudah'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-smile fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Quiz Sedang
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sedang'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-meh fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Quiz Sulit
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['sulit'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-frown fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.quizzes.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Quiz</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Soal atau pilihan jawaban...">
            </div>
            <div class="col-md-2">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level">
                    <option value="">Semua Level</option>
                    <option value="mudah" {{ request('level') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                    <option value="sedang" {{ request('level') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="sulit" {{ request('level') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="level_asc" {{ request('sort') == 'level_asc' ? 'selected' : '' }}>Level: Mudah-Sulit</option>
                    <option value="level_desc" {{ request('sort') == 'level_desc' ? 'selected' : '' }}>Level: Sulit-Mudah</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tampilan</label>
                <div class="d-flex gap-2">
                    <button type="submit" name="grouped" value="" class="btn {{ !request('grouped') ? 'btn-primary' : 'btn-outline-primary' }} flex-fill">
                        <i class="fas fa-list"></i> List
                    </button>
                    <button type="submit" name="grouped" value="1" class="btn {{ request('grouped') ? 'btn-primary' : 'btn-outline-primary' }} flex-fill">
                        <i class="fas fa-layer-group"></i> Grup
                    </button>
                </div>
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

@if(request('grouped'))
    <!-- Tampilan Grouped -->
    @foreach(['mudah' => 'success', 'sedang' => 'warning', 'sulit' => 'danger'] as $levelName => $colorClass)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-{{ $colorClass }} text-white py-3">
                <h6 class="m-0 font-weight-bold text-uppercase">
                    <i class="fas fa-{{ $levelName == 'mudah' ? 'smile' : ($levelName == 'sedang' ? 'meh' : 'frown') }} me-2"></i>
                    Quiz Level {{ ucfirst($levelName) }} ({{ $quizzesGrouped[$levelName]->count() }} soal)
                </h6>
            </div>
            <div class="card-body">
                @if($quizzesGrouped[$levelName]->count() > 0)
                    <div class="row">
                        @foreach($quizzesGrouped[$levelName] as $quiz)
                            <div class="col-md-6 mb-3">
                                <div class="card border-{{ $colorClass }}">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ Str::limit($quiz->soal, 80) }}</h6>
                                        <div class="small text-muted mb-2">
                                            <strong>Jawaban:</strong> {{ strtoupper($quiz->jawaban_benar) }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $quiz->created_at->format('d M Y') }}</small>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteQuiz({{ $quiz->id }})" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada quiz level {{ $levelName }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@else
    <!-- Tampilan List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Quiz</h6>
        </div>
        <div class="card-body">
            @if($quizzes && $quizzes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Level</th>
                                <th>Jawaban Benar</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizzes as $index => $quiz)
                            <tr>
                                <td>{{ $quizzes->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($quiz->soal, 100) }}</div>
                                    <div class="small text-muted mt-1">
                                        <strong>A:</strong> {{ Str::limit($quiz->pilihan_a, 30) }}<br>
                                        <strong>B:</strong> {{ Str::limit($quiz->pilihan_b, 30) }}<br>
                                        <strong>C:</strong> {{ Str::limit($quiz->pilihan_c, 30) }}<br>
                                        <strong>D:</strong> {{ Str::limit($quiz->pilihan_d, 30) }}
                                    </div>
                                </td>
                                <td>
                                    @if($quiz->level == 'mudah')
                                        <span class="badge bg-success">Mudah</span>
                                    @elseif($quiz->level == 'sedang')
                                        <span class="badge bg-warning">Sedang</span>
                                    @else
                                        <span class="badge bg-danger">Sulit</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ strtoupper($quiz->jawaban_benar) }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $quiz->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteQuiz({{ $quiz->id }})" title="Hapus">
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
                {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $quizzes->firstItem() }} - {{ $quizzes->lastItem() }} dari {{ $quizzes->total() }} quiz
                    </div>
                    {{ $quizzes->links() }}
                </div> --}}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada quiz ditemukan</h5>
                    <p class="text-muted">Belum ada data quiz atau sesuaikan filter pencarian</p>
                    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Quiz Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Form Delete (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteQuiz(quizId) {
    if (confirm('Apakah Anda yakin ingin menghapus quiz ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/quizzes/${quizId}`;
        form.submit();
    }
}

// Auto submit form ketika mengubah tampilan
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort');
    const levelSelect = document.getElementById('level');

    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    if (levelSelect) {
        levelSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endpush
