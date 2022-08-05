<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStyleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'app_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bg_type' => 'required|in:color,image',
            'bg_color' => 'required_if:bg_type,color',
            'bg_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
