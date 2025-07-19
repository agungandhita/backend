@extends('admin.layouts.main')

@section('title', 'Detail Quiz - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Detail Quiz</h2>
        <p class="text-muted mb-0">Informasi lengkap soal quiz</p>
    </div>
    <div>
        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-warning me-2">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Soal Quiz</h5>
                <span class="badge bg-{{ $quiz->level == 'mudah' ? 'success' : ($quiz->level == 'sedang' ? 'warning' : 'danger') }} fs-6">
                    {{ ucfirst($quiz->level) }}
                </span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-primary">Pertanyaan:</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $quiz->soal }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-primary">Pilihan Jawaban:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex align-items-center p-3 border rounded {{ $quiz->jawaban_benar == 'a' ? 'bg-success text-white' : 'bg-white' }}">
                                    <strong class="me-3">A.</strong>
                                    <span>{{ $quiz->pilihan_a }}</span>
                                    @if($quiz->jawaban_benar == 'a')
                                        <i class="fas fa-check-circle ms-auto"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center p-3 border rounded {{ $quiz->jawaban_benar == 'c' ? 'bg-success text-white' : 'bg-white' }}">
                                    <strong class="me-3">C.</strong>
                                    <span>{{ $quiz->pilihan_c }}</span>
                                    @if($quiz->jawaban_benar == 'c')
                                        <i class="fas fa-check-circle ms-auto"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex align-items-center p-3 border rounded {{ $quiz->jawaban_benar == 'b' ? 'bg-success text-white' : 'bg-white' }}">
                                    <strong class="me-3">B.</strong>
                                    <span>{{ $quiz->pilihan_b }}</span>
                                    @if($quiz->jawaban_benar == 'b')
                                        <i class="fas fa-check-circle ms-auto"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center p-3 border rounded {{ $quiz->jawaban_benar == 'd' ? 'bg-success text-white' : 'bg-white' }}">
                                    <strong class="me-3">D.</strong>
                                    <span>{{ $quiz->pilihan_d }}</span>
                                    @if($quiz->jawaban_benar == 'd')
                                        <i class="fas fa-check-circle ms-auto"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Jawaban Benar:</strong> {{ strtoupper($quiz->jawaban_benar) }} -
                    @switch($quiz->jawaban_benar)
                        @case('a')
                            {{ $quiz->pilihan_a }}
                            @break
                        @case('b')
                            {{ $quiz->pilihan_b }}
                            @break
                        @case('c')
                            {{ $quiz->pilihan_c }}
                            @break
                        @case('d')
                            {{ $quiz->pilihan_d }}
                            @break
                    @endswitch
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
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Quiz
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteQuiz({{ $quiz->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Quiz
                    </button>
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i>Daftar Quiz
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Informasi Quiz</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Level Kesulitan:</small><br>
                    <span class="badge bg-{{ $quiz->level == 'mudah' ? 'success' : ($quiz->level == 'sedang' ? 'warning' : 'danger') }}">
                        {{ ucfirst($quiz->level) }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Jawaban Benar:</small><br>
                    <span class="badge bg-success">{{ strtoupper($quiz->jawaban_benar) }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Dibuat:</small><br>
                    <span>{{ $quiz->created_at->format('d M Y H:i') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Terakhir diupdate:</small><br>
                    <span>{{ $quiz->updated_at->format('d M Y H:i') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Panjang Soal:</small><br>
                    <span>{{ strlen($quiz->soal) }} karakter</span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Statistik Level</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Level {{ ucfirst($quiz->level) }}:</strong><br>
                    @switch($quiz->level)
                        @case('mudah')
                            Soal tingkat dasar dengan konsep fundamental yang mudah dipahami.
                            @break
                        @case('sedang')
                            Soal tingkat menengah yang memerlukan pemahaman dan aplikasi konsep.
                            @break
                        @case('sulit')
                            Soal tingkat lanjut yang memerlukan analisis dan sintesis mendalam.
                            @break
                    @endswitch
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
function deleteQuiz(quizId) {
    if (confirm('Apakah Anda yakin ingin menghapus quiz ini?')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/quizzes/${quizId}`;
        form.submit();
    }
}
</script>
@endpush
