<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required', 'string',
            'category_id' => ['required', 'array'],
            'category_id.*' => ['sometimes', 'numeric', 'exists:categories,id'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'description' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf'],
            'link_gdrive' => ['nullable', 'string'],
            'price' => ['required', 'integer'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Produk wajib diisi.',
            'category.required' => 'Kategori Produk wajib diisi.',
            'thumbnail.required' => 'Thumbnail Produk wajib diisi.',
            'description.required' => 'Deskripsi Produk wajib diisi.',
            'file.required' => 'File Produk wajib diisi.',
            'price.required' => 'Harga Produk wajib diisi.',

            'group.exists' => 'Group Produk tidak ditemukan.',
            'category.exists' => 'Kategori Produk tidak ditemukan.',

            'file.mimes' => 'File harus bertipe PDF.',
            'file.file' => 'File harus bertipe PDF.',
            'thumbnail.image' => 'Thumbnail harus bertipe gambar.',
            'thumbnail.mimes' => 'Thumbnail harus bertipe gambar.',

            'link_gdrive.string' => 'Format isisan tidak sesuai.',
        ];
    }
}
