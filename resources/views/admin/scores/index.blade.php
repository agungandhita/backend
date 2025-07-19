@extends('admin.layouts.main')

@section('title', 'Kelola Skor - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Kelola Skor Siswa</h2>
        <p class="text-muted mb-0">Manajemen hasil kuis siswa</p>
    </div>
    <a href="{{ route('admin.scores.statistics') }}" class="btn btn-info">
        <i class="fas fa-chart-bar me-2"></i>Lihat Statistik
    </a>
</div>

<!-- Filter dan Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.scores.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Siswa</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Nama siswa...">
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
                <label for="min_score" class="form-label">Skor Min</label>
                <input type="number" class="form-control" id="min_score" name="min_score"
                       value="{{ request('min_score') }}" min="0" max="100" placeholder="0">
            </div>
            <div class="col-md-2">
                <label for="max_score" class="form-label">Skor Max</label>
                <input type="number" class="form-control" id="max_score" name="max_score"
                       value="{{ request('max_score') }}" min="0" max="100" placeholder="100">
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="score_high" {{ request('sort') == 'score_high' ? 'selected' : '' }}>Skor Tertinggi</option>
                    <option value="score_low" {{ request('sort') == 'score_low' ? 'selected' : '' }}>Skor Terendah</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistik Ringkas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0">{{ $stats['total_attempts'] ?? 0 }}</div>
                        <div class="small">Total Percobaan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-trophy fa-2x"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0">{{ number_format($stats['average_score'] ?? 0, 1) }}</div>
                        <div class="small">Rata-rata Skor</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0">{{ $stats['highest_score'] ?? 0 }}</div>
                        <div class="small">Skor Tertinggi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0">{{ $stats['active_students'] ?? 0 }}</div>
                        <div class="small">Siswa Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Skor -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Skor Siswa</h6>
    </div>
    <div class="card-body">
        @if($scores->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>Level</th>
                            <th>Skor</th>
                            <th>Benar/Total</th>
                            <th>Persentase</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $index => $score)
                        <tr>
                            <td>{{ $scores->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($score->user->foto)
                                        <img src="{{ asset('storage/' . $score->user->foto) }}"
                                             alt="{{ $score->user->name }}"
                                             class="rounded-circle me-2"
                                             width="32" height="32">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 32px; height: 32px;">
                                            <i class="fas fa-user text-white small"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $score->user->name }}</div>
                                        @if($score->user->kelas)
                                            <small class="text-muted">{{ $score->user->kelas }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge
                                    @if($score->level == 'mudah') bg-success
                                    @elseif($score->level == 'sedang') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($score->level) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold
                                    @if($score->skor >= 80) text-success
                                    @elseif($score->skor >= 60) text-warning
                                    @else text-danger
                                    @endif">
                                    {{ $score->skor }}
                                </span>
                            </td>
                            <td>
                                <span class="text-success fw-bold">{{ $score->benar }}</span>
                                <span class="text-muted">/</span>
                                <span class="text-muted">{{ $score->total_soal }}</span>
                                <br>
                                <small class="text-danger">{{ $score->salah }} salah</small>
                            </td>
                            <td>
                                <div class="progress" style="height: 8px; width: 80px;">
                                    <div class="progress-bar
                                        @if($score->skor >= 80) bg-success
                                        @elseif($score->skor >= 60) bg-warning
                                        @else bg-danger
                                        @endif"
                                         style="width: {{ $score->skor }}%"></div>
                                </div>
                                <small class="text-muted">{{ $score->skor }}%</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $score->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.scores.show', $score) }}"
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteScore({{ $score->id }})" title="Hapus">
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
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $scores->firstItem() }} - {{ $scores->lastItem() }} dari {{ $scores->total() }} skor
                </div>
                {{ $scores->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada skor ditemukan</h5>
                <p class="text-muted">Belum ada data skor siswa atau sesuaikan filter pencarian</p>
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
function deleteScore(scoreId) {
    if (confirm('Apakah Anda yakin ingin menghapus skor ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/scores/${scoreId}`;
        form.submit();
    }
}
</script>
@endpush
