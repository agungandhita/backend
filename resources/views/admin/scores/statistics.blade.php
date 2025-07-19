@extends('admin.layouts.main')

@section('title', 'Statistik Skor - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Statistik Skor Siswa</h2>
        <p class="text-muted mb-0">Analisis performa siswa dalam kuis</p>
    </div>
    <a href="{{ route('admin.scores.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Skor
    </a>
</div>

<!-- Statistik Umum -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <div class="h3 mb-0">{{ $statistics['total_attempts'] }}</div>
                        <div class="small">Total Percobaan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-trophy fa-2x"></i>
                    </div>
                    <div>
                        <div class="h3 mb-0">{{ number_format($statistics['average_score'], 1) }}</div>
                        <div class="small">Rata-rata Skor</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-warning text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <div>
                        <div class="h3 mb-0">{{ $statistics['highest_score'] }}</div>
                        <div class="small">Skor Tertinggi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <div class="h3 mb-0">{{ $statistics['active_students'] }}</div>
                        <div class="small">Siswa Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik per Level -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik per Level</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($statistics['by_level'] as $level => $data)
                    <div class="col-md-4 mb-3">
                        <div class="card border-start border-4
                            @if($level == 'mudah') border-success
                            @elseif($level == 'sedang') border-warning
                            @else border-danger
                            @endif h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title
                                    @if($level == 'mudah') text-success
                                    @elseif($level == 'sedang') text-warning
                                    @else text-danger
                                    @endif">
                                    {{ ucfirst($level) }}
                                </h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="h4 mb-0">{{ $data['total'] }}</div>
                                        <small class="text-muted">Percobaan</small>
                                    </div>
                                    <div class="col-6">
                                        <div class="h4 mb-0">{{ number_format($data['average'], 1) }}</div>
                                        <small class="text-muted">Rata-rata</small>
                                    </div>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar
                                        @if($level == 'mudah') bg-success
                                        @elseif($level == 'sedang') bg-warning
                                        @else bg-danger
                                        @endif"
                                         style="width: {{ $data['average'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Skor</h6>
            </div>
            <div class="card-body">
                @php
                    $excellent = $statistics['score_distribution']['excellent'] ?? 0;
                    $good = $statistics['score_distribution']['good'] ?? 0;
                    $fair = $statistics['score_distribution']['fair'] ?? 0;
                    $poor = $statistics['score_distribution']['poor'] ?? 0;
                    $total = $excellent + $good + $fair + $poor;
                @endphp

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-success">Sangat Baik (80-100)</span>
                        <span class="fw-bold">{{ $excellent }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success"
                             style="width: {{ $total > 0 ? ($excellent / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-info">Baik (70-79)</span>
                        <span class="fw-bold">{{ $good }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-info"
                             style="width: {{ $total > 0 ? ($good / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-warning">Cukup (60-69)</span>
                        <span class="fw-bold">{{ $fair }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-warning"
                             style="width: {{ $total > 0 ? ($fair / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-danger">Kurang (<60)</span>
                        <span class="fw-bold">{{ $poor }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-danger"
                             style="width: {{ $total > 0 ? ($poor / $total) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Performers -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top 10 Siswa Terbaik</h6>
            </div>
            <div class="card-body">
                @if(count($statistics['top_students']) > 0)
                    @foreach($statistics['top_students'] as $index => $student)
                    <div class="d-flex align-items-center mb-3 p-2 rounded
                        @if($index == 0) bg-warning bg-opacity-10
                        @elseif($index == 1) bg-secondary bg-opacity-10
                        @elseif($index == 2) bg-orange bg-opacity-10
                        @endif">
                        <div class="me-3">
                            @if($index == 0)
                                <i class="fas fa-trophy text-warning fa-lg"></i>
                            @elseif($index == 1)
                                <i class="fas fa-medal text-secondary fa-lg"></i>
                            @elseif($index == 2)
                                <i class="fas fa-award text-orange fa-lg"></i>
                            @else
                                <span class="badge bg-primary rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                    {{ $index + 1 }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $student->name }}</div>
                            @if($student->kelas)
                                <small class="text-muted">{{ $student->kelas }}</small>
                            @endif
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary">{{ number_format($student->average_score, 1) }}</div>
                            <small class="text-muted">{{ $student->total_attempts }} percobaan</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada data siswa</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
            </div>
            <div class="card-body">
                @if(count($statistics['recent_scores']) > 0)
                    @foreach($statistics['recent_scores'] as $score)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            @if($score->user->foto)
                                <img src="{{ asset('storage/' . $score->user->foto) }}"
                                     alt="{{ $score->user->name }}"
                                     class="rounded-circle"
                                     width="40" height="40">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $score->user->name }}</div>
                            <small class="text-muted">
                                Kuis {{ ucfirst($score->level) }} •
                                {{ $score->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge
                                @if($score->skor >= 80) bg-success
                                @elseif($score->skor >= 60) bg-warning
                                @else bg-danger
                                @endif">
                                {{ $score->skor }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-clock fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada aktivitas terbaru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
