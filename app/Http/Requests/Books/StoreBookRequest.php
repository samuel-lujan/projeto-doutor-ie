<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validation = [
            'titulo ' => 'required_without:titulo|string|min:01|max:255',
            'titulo' => 'required_without:titulo |string|min:01|max:255',
            'indices' => 'required|array',
            'indices.*' => 'required|array',
            'indices.*.titulo ' => 'required_without:titulo|string|min:1|max:255',
            'indices.*.titulo' => 'required_without:titulo |string|min:1|max:255',
            'indices.*.pagina' => 'required|integer',
            'indices.*.subindices' => 'nullable|array|min:0',
            'document'        => 'nullable|mimes:pdf|max:10000',
        ];
        return $validation;
    }
}
