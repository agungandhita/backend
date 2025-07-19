@extends('admin.layouts.main')

@section('title', 'Edit Quiz - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Edit Quiz</h2>
        <p class="text-muted mb-0">Ubah soal quiz</p>
    </div>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Quiz</h5>
            </div>
            <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="soal" class="form-label">Soal <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('soal') is-invalid @enderror"
                                  id="soal" name="soal" rows="4" required>{{ old('soal', $quiz->soal) }}</textarea>
                        @error('soal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_a" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_a') is-invalid @enderror"
                                       id="pilihan_a" name="pilihan_a" value="{{ old('pilihan_a', $quiz->pilihan_a) }}" required>
                                @error('pilihan_a')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_b" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_b') is-invalid @enderror"
                                       id="pilihan_b" name="pilihan_b" value="{{ old('pilihan_b', $quiz->pilihan_b) }}" required>
                                @error('pilihan_b')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_c" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_c') is-invalid @enderror"
                                       id="pilihan_c" name="pilihan_c" value="{{ old('pilihan_c', $quiz->pilihan_c) }}" required>
                                @error('pilihan_c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_d" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_d') is-invalid @enderror"
                                       id="pilihan_d" name="pilihan_d" value="{{ old('pilihan_d', $quiz->pilihan_d) }}" required>
                                @error('pilihan_d')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jawaban_benar" class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                <select class="form-select @error('jawaban_benar') is-invalid @enderror"
                                        id="jawaban_benar" name="jawaban_benar" required>
                                    <option value="">Pilih jawaban benar</option>
                                    <option value="a" {{ old('jawaban_benar', $quiz->jawaban_benar) == 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('jawaban_benar', $quiz->jawaban_benar) == 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('jawaban_benar', $quiz->jawaban_benar) == 'c' ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ old('jawaban_benar', $quiz->jawaban_benar) == 'd' ? 'selected' : '' }}>D</option>
                                </select>
                                @error('jawaban_benar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="level" class="form-label">Level Kesulitan <span class="text-danger">*</span></label>
                                <select class="form-select @error('level') is-invalid @enderror"
                                        id="level" name="level" required>
                                    <option value="">Pilih level kesulitan</option>
                                    <option value="mudah" {{ old('level', $quiz->level) == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                    <option value="sedang" {{ old('level', $quiz->level) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="sulit" {{ old('level', $quiz->level) == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preview Current Quiz -->
                    <div class="mb-3">
                        <label class="form-label">Preview Quiz Saat Ini</label>
                        <div class="bg-light p-3 rounded">
                            <h6>{{ $quiz->soal }}</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $quiz->jawaban_benar == 'a' ? 'success' : 'secondary' }} me-2">A</span>
                                        {{ $quiz->pilihan_a }}
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $quiz->jawaban_benar == 'c' ? 'success' : 'secondary' }} me-2">C</span>
                                        {{ $quiz->pilihan_c }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $quiz->jawaban_benar == 'b' ? 'success' : 'secondary' }} me-2">B</span>
                                        {{ $quiz->pilihan_b }}
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-{{ $quiz->jawaban_benar == 'd' ? 'success' : 'secondary' }} me-2">D</span>
                                        {{ $quiz->pilihan_d }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-{{ $quiz->level == 'mudah' ? 'success' : ($quiz->level == 'sedang' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($quiz->level) }}
                                </span>
                                <span class="badge bg-success ms-2">Jawaban: {{ strtoupper($quiz->jawaban_benar) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Quiz
                    </button>
                    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-info">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi Quiz</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Level Saat Ini:</small><br>
                    <span class="badge bg-{{ $quiz->level == 'mudah' ? 'success' : ($quiz->level == 'sedang' ? 'warning' : 'danger') }}">
                        {{ ucfirst($quiz->level) }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Jawaban Benar Saat Ini:</small><br>
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

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tips Edit:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Pastikan soal jelas dan mudah dipahami</li>
                        <li>Periksa kembali jawaban yang benar</li>
                        <li>Sesuaikan level dengan tingkat kesulitan</li>
                        <li>Hindari pilihan jawaban yang ambigu</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Preview Live</h5>
            </div>
            <div class="card-body">
                <div id="quiz-preview">
                    <p class="text-muted">Preview akan update saat Anda mengedit...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Real-time preview
function updatePreview() {
    const soal = document.getElementById('soal').value;
    const pilihanA = document.getElementById('pilihan_a').value;
    const pilihanB = document.getElementById('pilihan_b').value;
    const pilihanC = document.getElementById('pilihan_c').value;
    const pilihanD = document.getElementById('pilihan_d').value;
    const jawaban = document.getElementById('jawaban_benar').value;
    const level = document.getElementById('level').value;

    let preview = '<div class="quiz-preview">';

    if (soal) {
        preview += `<h6>Soal:</h6><p>${soal}</p>`;
    }

    if (pilihanA || pilihanB || pilihanC || pilihanD) {
        preview += '<h6>Pilihan:</h6><ul class="list-unstyled">';
        if (pilihanA) preview += `<li class="mb-1"><span class="badge bg-${jawaban === 'a' ? 'success' : 'secondary'} me-2">A</span>${pilihanA}</li>`;
        if (pilihanB) preview += `<li class="mb-1"><span class="badge bg-${jawaban === 'b' ? 'success' : 'secondary'} me-2">B</span>${pilihanB}</li>`;
        if (pilihanC) preview += `<li class="mb-1"><span class="badge bg-${jawaban === 'c' ? 'success' : 'secondary'} me-2">C</span>${pilihanC}</li>`;
        if (pilihanD) preview += `<li class="mb-1"><span class="badge bg-${jawaban === 'd' ? 'success' : 'secondary'} me-2">D</span>${pilihanD}</li>`;
        preview += '</ul>';
    }

    if (level) {
        const levelClass = level === 'mudah' ? 'success' : (level === 'sedang' ? 'warning' : 'danger');
        preview += `<span class="badge bg-${levelClass}">${level.charAt(0).toUpperCase() + level.slice(1)}</span>`;
    }

    if (jawaban) {
        preview += ` <span class="badge bg-success ms-2">Jawaban: ${jawaban.toUpperCase()}</span>`;
    }

    preview += '</div>';

    document.getElementById('quiz-preview').innerHTML = preview;
}

// Add event listeners
document.getElementById('soal').addEventListener('input', updatePreview);
document.getElementById('pilihan_a').addEventListener('input', updatePreview);
document.getElementById('pilihan_b').addEventListener('input', updatePreview);
document.getElementById('pilihan_c').addEventListener('input', updatePreview);
document.getElementById('pilihan_d').addEventListener('input', updatePreview);
document.getElementById('jawaban_benar').addEventListener('change', updatePreview);
document.getElementById('level').addEventListener('change', updatePreview);

// Initial preview
updatePreview();
</script>
@endpush
