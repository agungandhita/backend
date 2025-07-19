@extends('admin.layouts.main')

@section('title', 'Detail User - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail User</h2>
        <p class="text-muted mb-0">Informasi lengkap user</p>
    </div>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}"
                                 class="img-fluid rounded-circle mb-3"
                                 alt="{{ $user->name }}"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3"
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-muted"></i>
                            </div>
                        @endif
                        <h4>{{ $user->name }}</h4>
                        @if($user->kelas)
                            <span class="badge bg-primary">{{ $user->kelas }}</span>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5 class="text-primary mb-3">Informasi Personal</h5>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Nama Lengkap:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Kelas:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $user->kelas ?? 'Tidak diset' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Bergabung:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $user->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <strong>Terakhir Update:</strong>
                            </div>
                            <div class="col-sm-8">
                                {{ $user->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Quiz -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="mb-0">Statistik Quiz</h5>
            </div>
            <div class="card-body">
                @if($user->scores->count() > 0)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-primary">{{ $user->scores->count() }}</h4>
                                <small class="text-muted">Total Attempt</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-success">{{ number_format($user->scores->avg('skor'), 1) }}</h4>
                                <small class="text-muted">Rata-rata Skor</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-info">{{ $user->scores->max('skor') }}</h4>
                                <small class="text-muted">Skor Tertinggi</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-warning">{{ $user->scores->min('skor') }}</h4>
                                <small class="text-muted">Skor Terendah</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Riwayat Quiz Terbaru</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Skor</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->scores->take(5) as $score)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $score->level == 'mudah' ? 'success' : ($score->level == 'sedang' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($score->level) }}
                                        </span>
                                    </td>
                                    <td>{{ $score->skor }}</td>
                                    <td>{{ $score->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada riwayat quiz</h6>
                        <p class="text-muted">User ini belum pernah mengikuti quiz</p>
                    </div>
                @endif
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
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteUser({{ $user->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i>Daftar User
                    </a>
                </div>
            </div>
        </div>

        @if($user->scores->count() > 0)
        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik per Level</h5>
            </div>
            <div class="card-body">
                @foreach(['mudah', 'sedang', 'sulit'] as $level)
                    @php
                        $levelScores = $user->scores->where('level', $level);
                    @endphp
                    @if($levelScores->count() > 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-{{ $level == 'mudah' ? 'success' : ($level == 'sedang' ? 'warning' : 'danger') }}">{{ ucfirst($level) }}</span>
                            <small>{{ $levelScores->count() }}x</small>
                        </div>
                        <div class="mt-1">
                            <small class="text-muted">Rata-rata: {{ number_format($levelScores->avg('skor'), 1) }}</small>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
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
function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus.')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/users/${userId}`;
        form.submit();
    }
}
</script>
@endpush
