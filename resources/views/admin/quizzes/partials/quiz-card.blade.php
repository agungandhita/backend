<div class="card mb-4 border-0 shadow-sm hover-lift quiz-card
    @if($quiz->level == 'mudah') border-start border-success border-4
    @elseif($quiz->level == 'sedang') border-start border-warning border-4
    @else border-start border-danger border-4
    @endif">
    <div class="card-body p-4">
        <div class="row align-items-start">
            <!-- Quiz Number -->
            <div class="col-lg-1 col-md-2 mb-3 mb-lg-0">
                <div class="text-center">
                    <div class="quiz-number badge bg-primary text-white fs-6 fw-bold p-2 rounded-circle" style="width: 45px; height: 45px; line-height: 29px;">
                        #{{ $index }}
                    </div>
                </div>
            </div>
            
            <!-- Quiz Content -->
            <div class="col-lg-7 col-md-6 mb-3 mb-lg-0">
                <h5 class="mb-3 fw-bold text-dark quiz-question">{{ $quiz->soal }}</h5>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="option-item p-3 bg-light rounded-3 mb-2 border
                            {{ $quiz->jawaban_benar == 'a' ? 'border-success bg-success bg-opacity-10' : '' }}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2 fw-bold">A</span>
                                <span class="text-dark">{{ $quiz->pilihan_a }}</span>
                                @if($quiz->jawaban_benar == 'a')
                                    <i class="fas fa-check-circle text-success ms-auto"></i>
                                @endif
                            </div>
                        </div>
                        <div class="option-item p-3 bg-light rounded-3 border
                            {{ $quiz->jawaban_benar == 'b' ? 'border-success bg-success bg-opacity-10' : '' }}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2 fw-bold">B</span>
                                <span class="text-dark">{{ $quiz->pilihan_b }}</span>
                                @if($quiz->jawaban_benar == 'b')
                                    <i class="fas fa-check-circle text-success ms-auto"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="option-item p-3 bg-light rounded-3 mb-2 border
                            {{ $quiz->jawaban_benar == 'c' ? 'border-success bg-success bg-opacity-10' : '' }}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2 fw-bold">C</span>
                                <span class="text-dark">{{ $quiz->pilihan_c }}</span>
                                @if($quiz->jawaban_benar == 'c')
                                    <i class="fas fa-check-circle text-success ms-auto"></i>
                                @endif
                            </div>
                        </div>
                        <div class="option-item p-3 bg-light rounded-3 border
                            {{ $quiz->jawaban_benar == 'd' ? 'border-success bg-success bg-opacity-10' : '' }}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-2 fw-bold">D</span>
                                <span class="text-dark">{{ $quiz->pilihan_d }}</span>
                                @if($quiz->jawaban_benar == 'd')
                                    <i class="fas fa-check-circle text-success ms-auto"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="correct-answer-info">
                    <span class="badge bg-success fs-6 px-3 py-2 fw-semibold">
                        <i class="fas fa-check-circle me-2"></i>
                        Jawaban Benar: {{ strtoupper($quiz->jawaban_benar) }}
                    </span>
                </div>
            </div>
            
            <!-- Quiz Info -->
            <div class="col-lg-2 col-md-2 mb-3 mb-lg-0">
                <div class="quiz-info text-center">
                    <div class="mb-3">
                        <span class="badge fs-6 px-3 py-2 fw-semibold text-white
                            @if($quiz->level == 'mudah') bg-success
                            @elseif($quiz->level == 'sedang') bg-warning
                            @else bg-danger
                            @endif">
                            @if($quiz->level == 'mudah')
                                <i class="fas fa-smile me-1"></i>
                            @elseif($quiz->level == 'sedang')
                                <i class="fas fa-meh me-1"></i>
                            @else
                                <i class="fas fa-frown me-1"></i>
                            @endif
                            {{ ucfirst($quiz->level) }}
                        </span>
                    </div>
                    <div class="quiz-meta">
                        <div class="text-muted small mb-1">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i>
                            {{ $quiz->created_at->format('d M Y') }}
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-clock me-1 text-primary"></i>
                            {{ $quiz->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="col-lg-2 col-md-2">
                <div class="quiz-actions d-flex flex-column gap-2">
                    <a href="{{ route('admin.quizzes.show', $quiz) }}"
                       class="btn btn-outline-info btn-sm fw-semibold" title="Lihat Detail">
                        <i class="fas fa-eye me-2"></i>Detail
                    </a>
                    <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                       class="btn btn-outline-warning btn-sm fw-semibold" title="Edit Soal">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-sm fw-semibold"
                            onclick="deleteQuiz({{ $quiz->id }})" title="Hapus Soal">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
