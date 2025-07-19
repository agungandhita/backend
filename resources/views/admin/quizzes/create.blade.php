@extends('admin.layouts.main')

@section('title', 'Tambah Quiz - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Tambah Quiz Baru</h2>
        <p class="text-muted mb-0">Buat soal quiz baru</p>
    </div>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Quiz</h5>
            </div>
            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="soal" class="form-label">Soal <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('soal') is-invalid @enderror"
                                  id="soal" name="soal" rows="4" required>{{ old('soal') }}</textarea>
                        @error('soal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_a" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_a') is-invalid @enderror"
                                       id="pilihan_a" name="pilihan_a" value="{{ old('pilihan_a') }}" required>
                                @error('pilihan_a')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_b" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_b') is-invalid @enderror"
                                       id="pilihan_b" name="pilihan_b" value="{{ old('pilihan_b') }}" required>
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
                                       id="pilihan_c" name="pilihan_c" value="{{ old('pilihan_c') }}" required>
                                @error('pilihan_c')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pilihan_d" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pilihan_d') is-invalid @enderror"
                                       id="pilihan_d" name="pilihan_d" value="{{ old('pilihan_d') }}" required>
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
                                    <option value="a" {{ old('jawaban_benar') == 'a' ? 'selected' : '' }}>A</option>
                                    <option value="b" {{ old('jawaban_benar') == 'b' ? 'selected' : '' }}>B</option>
                                    <option value="c" {{ old('jawaban_benar') == 'c' ? 'selected' : '' }}>C</option>
                                    <option value="d" {{ old('jawaban_benar') == 'd' ? 'selected' : '' }}>D</option>
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
                                    <option value="mudah" {{ old('level') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                    <option value="sedang" {{ old('level') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="sulit" {{ old('level') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Quiz
                    </button>
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
                <h5 class="mb-0">Panduan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tips Membuat Quiz:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Buat soal yang jelas dan mudah dipahami</li>
                        <li>Pastikan pilihan jawaban logis</li>
                        <li>Hanya ada satu jawaban yang benar</li>
                        <li>Sesuaikan level dengan tingkat kesulitan</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Level Kesulitan:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Mudah:</strong> Soal dasar, konsep fundamental</li>
                        <li><strong>Sedang:</strong> Soal aplikasi, pemahaman</li>
                        <li><strong>Sulit:</strong> Soal analisis, sintesis</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header">
                <h5 class="mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <div id="quiz-preview">
                    <p class="text-muted">Preview soal akan muncul di sini saat Anda mengetik...</p>
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
        preview += '<h6>Pilihan:</h6><ul>';
        if (pilihanA) preview += `<li><strong>A.</strong> ${pilihanA} ${jawaban === 'a' ? '<span class="badge bg-success">✓</span>' : ''}</li>`;
        if (pilihanB) preview += `<li><strong>B.</strong> ${pilihanB} ${jawaban === 'b' ? '<span class="badge bg-success">✓</span>' : ''}</li>`;
        if (pilihanC) preview += `<li><strong>C.</strong> ${pilihanC} ${jawaban === 'c' ? '<span class="badge bg-success">✓</span>' : ''}</li>`;
        if (pilihanD) preview += `<li><strong>D.</strong> ${pilihanD} ${jawaban === 'd' ? '<span class="badge bg-success">✓</span>' : ''}</li>`;
        preview += '</ul>';
    }

    if (level) {
        const levelClass = level === 'mudah' ? 'success' : (level === 'sedang' ? 'warning' : 'danger');
        preview += `<span class="badge bg-${levelClass}">${level.charAt(0).toUpperCase() + level.slice(1)}</span>`;
    }

    preview += '</div>';

    if (!soal && !pilihanA && !pilihanB && !pilihanC && !pilihanD) {
        preview = '<p class="text-muted">Preview soal akan muncul di sini saat Anda mengetik...</p>';
    }

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
</script>
@endpush
