<?php

namespace App\Http\Requests\Other;

use Illuminate\Foundation\Http\FormRequest;

class CKEditorUploadImageRequest extends FormRequest
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
        return [
            'upload' => 'required|file',
            'CKEditorFuncNum' => 'required|numeric'
        ];
    }
}
