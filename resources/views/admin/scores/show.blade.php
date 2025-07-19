@extends('admin.layouts.main')

@section('title', 'Detail Score - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail Score</h2>
        <p class="text-muted mb-0">Informasi lengkap hasil quiz</p>
    </div>
    <div>
        <a href="{{ route('admin.scores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hasil Quiz</h5>
                <span class="badge bg-{{ $score->level == 'mudah' ? 'success' : ($score->level == 'sedang' ? 'warning' : 'danger') }} fs-6">
                    {{ ucfirst($score->level) }}
                </span>
            </div>
            <div class="card-body">
                <!-- User Info -->
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        @if($score->user->foto)
                            <img src="{{ asset('storage/' . $score->user->foto) }}"
                                 class="img-fluid rounded-circle mb-2"
                                 alt="{{ $score->user->name }}"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mx-auto mb-2"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-muted"></i>
                            </div>
                        @endif
                        <h6>{{ $score->user->name }}</h6>
                        @if($score->user->kelas)
                            <span class="badge bg-primary">{{ $score->user->kelas }}</span>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-primary mb-0">{{ $score->skor }}</h3>
                                    <small class="text-muted">Skor</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-{{ $score->level == 'mudah' ? 'success' : ($score->level == 'sedang' ? 'warning' : 'danger') }} mb-0">
                                        {{ ucfirst($score->level) }}
                                    </h3>
                                    <small class="text-muted">Level</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-info mb-0">
                                        @php
                                            $percentage = ($score->skor / 100) * 100;
                                            if ($percentage >= 80) {
                                                $grade = 'A';
                                                $gradeClass = 'success';
                                            } elseif ($percentage >= 70) {
                                                $grade = 'B';
                                                $gradeClass = 'info';
                                            } elseif ($percentage >= 60) {
                                                $grade = 'C';
                                                $gradeClass = 'warning';
                                            } else {
                                                $grade = 'D';
                                                $gradeClass = 'danger';
                                            }
                                        @endphp
                                        <span class="text-{{ $gradeClass }}">{{ $grade }}</span>
                                    </h3>
                                    <small class="text-muted">Grade</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Score Analysis -->
                <div class="mb-4">
                    <h6 class="text-primary">Analisis Hasil</h6>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar bg-{{ $gradeClass }}"
                             role="progressbar"
                             style="width: {{ $score->skor }}%"
                             aria-valuenow="{{ $score->skor }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            {{ $score->skor }}%
                        </div>
                    </div>

                    <div class="alert alert-{{ $gradeClass }}">
                        <i class="fas fa-{{ $percentage >= 70 ? 'check-circle' : 'exclamation-triangle' }} me-2"></i>
                        <strong>Hasil:</strong>
                        @if($percentage >= 80)
                            Excellent! Pemahaman sangat baik pada level {{ $score->level }}.
                        @elseif($percentage >= 70)
                            Good! Pemahaman baik pada level {{ $score->level }}.
                        @elseif($percentage >= 60)
                            Fair. Masih perlu peningkatan pada level {{ $score->level }}.
                        @else
                            Needs Improvement. Perlu belajar lebih giat pada level {{ $score->level }}.
                        @endif
                    </div>
                </div>

                <!-- Quiz Details -->
                <div class="mb-4">
                    <h6 class="text-primary">Detail Quiz</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Tanggal Quiz:</small><br>
                            <span>{{ $score->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Durasi:</small><br>
                            <span>{{ $score->created_at->diffForHumans() }}</span>
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
                    <a href="{{ route('admin.users.show', $score->user) }}" class="btn btn-info">
                        <i class="fas fa-user me-2"></i>Lihat Profil User
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteScore({{ $score->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Score
                    </button>
                    <a href="{{ route('admin.scores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i>Daftar Score
                    </a>
                    <a href="{{ route('admin.scores.statistics') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi User</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Nama:</small><br>
                    <strong>{{ $score->user->name }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Email:</small><br>
                    <span>{{ $score->user->email }}</span>
                </div>

                @if($score->user->kelas)
                <div class="mb-3">
                    <small class="text-muted">Kelas:</small><br>
                    <span class="badge bg-primary">{{ $score->user->kelas }}</span>
                </div>
                @endif

                <div class="mb-3">
                    <small class="text-muted">Bergabung:</small><br>
                    <span>{{ $score->user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik User</h5>
            </div>
            <div class="card-body">
                @php
                    $userScores = $score->user->scores;
                    $totalAttempts = $userScores->count();
                    $averageScore = $userScores->avg('skor');
                    $bestScore = $userScores->max('skor');
                    $levelStats = $userScores->groupBy('level');
                @endphp

                <div class="mb-3">
                    <small class="text-muted">Total Attempt:</small><br>
                    <span class="badge bg-info">{{ $totalAttempts }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Rata-rata Skor:</small><br>
                    <span class="badge bg-success">{{ number_format($averageScore, 1) }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Skor Terbaik:</small><br>
                    <span class="badge bg-warning">{{ $bestScore }}</span>
                </div>

                <hr>

                <h6 class="text-muted mb-2">Per Level:</h6>
                @foreach(['mudah', 'sedang', 'sulit'] as $level)
                    @if(isset($levelStats[$level]))
                        <div class="mb-2">
                            <span class="badge bg-{{ $level == 'mudah' ? 'success' : ($level == 'sedang' ? 'warning' : 'danger') }} me-2">
                                {{ ucfirst($level) }}
                            </span>
                            <small>{{ $levelStats[$level]->count() }}x ({{ number_format($levelStats[$level]->avg('skor'), 1) }})</small>
                        </div>
                    @endif
                @endforeach
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
function deleteScore(scoreId) {
    if (confirm('Apakah Anda yakin ingin menghapus score ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/scores/${scoreId}`;
        form.submit();
    }
}
</script>
@endpush
