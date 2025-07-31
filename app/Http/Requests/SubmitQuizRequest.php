<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*.quiz_id' => 'required|exists:quizzes,id',
            'answers.*.jawaban' => 'nullable|in:a,b,c,d',
            'level' => 'required|in:mudah,sedang,sulit',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'answers.required' => 'Jawaban wajib diisi.',
            'answers.array' => 'Format jawaban tidak valid.',
            'answers.*.quiz_id.required' => 'ID quiz wajib diisi.',
            'answers.*.quiz_id.exists' => 'Quiz tidak ditemukan.',
            'answers.*.jawaban.required' => 'Jawaban wajib dipilih.',
            'answers.*.jawaban.in' => 'Jawaban harus berupa a, b, c, atau d.',
            'level.required' => 'Level quiz wajib diisi.',
            'level.in' => 'Level harus mudah, sedang, atau sulit.',
        ];
    }
}
