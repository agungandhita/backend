<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToolRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fungsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|mimes:pdf|max:10240', // 10MB
            'kategori' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama alat wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'fungsi.required' => 'Fungsi alat wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar maksimal 5MB.',
            'url_video.url' => 'Format URL video tidak valid.',
            'file_pdf.mimes' => 'File harus berformat PDF.',
            'file_pdf.max' => 'Ukuran PDF maksimal 10MB.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'tags.array' => 'Tags harus berupa array.',
            'tags.*.string' => 'Setiap tag harus berupa teks.',
        ];
    }
}