@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="p-4">
    <!-- Header Dashboard -->
    <div class="mb-4">
        <h1 class="h2 fw-bold text-dark">Dashboard</h1>
        <p class="text-muted">Selamat datang di panel admin Ensiklopedia Alat Teknik SMK</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Total Users</p>
                            <p class="h3 fw-bold mb-2">{{ $stats['total_users'] ?? 0 }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-primary">Siswa: {{ $stats['total_students'] ?? 0 }}</span>
                                <span class="badge bg-info">Admin: {{ $stats['total_admins'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Tools Teknik</p>
                            <p class="h3 fw-bold mb-2">{{ $stats['total_tools'] ?? 0 }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-success">Alat Teknik</span>
                            </div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-tools text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Video Pembelajaran</p>
                            <p class="h3 fw-bold mb-2">{{ $stats['total_videos'] ?? 0 }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info">Tutorial</span>
                            </div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="fas fa-play-circle text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="small fw-medium text-muted mb-1">Total Kuis</p>
                            <p class="h3 fw-bold mb-2">{{ $stats['total_quizzes'] ?? 0 }}</p>
                            <div class="d-flex gap-1">
                                <span class="badge bg-warning text-dark">Mudah: {{ $stats['quiz_by_level']['mudah'] ?? 0 }}</span>
                                <span class="badge bg-orange text-white">Sedang: {{ $stats['quiz_by_level']['sedang'] ?? 0 }}</span>
                                <span class="badge bg-danger">Sulit: {{ $stats['quiz_by_level']['sulit'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="fas fa-question-circle text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Alat Teknik Terbaru</h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_tools']) && $stats['recent_tools']->count() > 0)
                        @foreach($stats['recent_tools'] as $tool)
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                            <div class="d-flex align-items-center">
                                @if($tool->gambar)
                                    <img src="{{ asset('storage/' . $tool->gambar) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-tools text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="fw-medium mb-1">{{ $tool->nama }}</p>
                                    <p class="small text-muted mb-0">{{ Str::limit($tool->fungsi, 50) }}</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">Aktif</span>
                                <p class="small text-muted mt-1">{{ $tool->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tools text-muted fs-1 mb-3"></i>
                            <p class="text-muted">Belum ada alat teknik terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Statistik Pembelajaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Total Siswa Aktif</span>
                        <span class="fw-medium">{{ $stats['active_students'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-muted">Video Ditonton Bulan Ini</span>
                        <span class="fw-medium">{{ $stats['monthly_video_views'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="small text-muted">Rata-rata Skor Kuis</span>
                        <span class="fw-medium">{{ number_format($stats['average_score'] ?? 0, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Scores Section -->
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Skor Terbaru</h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_scores']) && $stats['recent_scores']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Level</th>
                                        <th>Skor</th>
                                        <th>Persentase</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_scores'] as $score)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($score->user->foto)
                                                    <img src="{{ asset('storage/' . $score->user->foto) }}" class="rounded-circle me-2" width="32" height="32">
                                                @else
                                                    <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-medium">{{ $score->user->name }}</div>
                                                    <small class="text-muted">{{ $score->user->kelas }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($score->level == 'mudah')
                                                <span class="badge bg-success">Mudah</span>
                                            @elseif($score->level == 'sedang')
                                                <span class="badge bg-warning text-dark">Sedang</span>
                                            @else
                                                <span class="badge bg-danger">Sulit</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $score->benar }}/{{ $score->total_soal }}</strong></td>
                                        <td>
                                            @php
                                                $percentage = ($score->benar / $score->total_soal) * 100;
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar
                                                        @if($percentage >= 80) bg-success
                                                        @elseif($percentage >= 60) bg-warning
                                                        @else bg-danger
                                                        @endif
                                                    " style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="small">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td><small class="text-muted">{{ $score->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line text-muted fs-1 mb-3"></i>
                            <p class="text-muted">Belum ada skor yang tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Statistik Skor</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Total Skor</span>
                            <span class="fw-bold">{{ $stats['total_scores'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Rata-rata Skor</span>
                            <span class="fw-bold">{{ number_format($stats['average_score'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: {{ $stats['average_score'] ?? 0 }}%"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Level Mudah</span>
                            <span class="badge bg-success">{{ $stats['quiz_by_level']['mudah'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Level Sedang</span>
                            <span class="badge bg-warning text-dark">{{ $stats['quiz_by_level']['sedang'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Level Sulit</span>
                            <span class="badge bg-danger">{{ $stats['quiz_by_level']['sulit'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
