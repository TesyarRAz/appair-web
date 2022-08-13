<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingPriceRequest extends FormRequest
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
            'per_kubik' => 'required',
            'abudemen' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'per_kubik' => str($this->per_kubik)->replace('.', '')->value(),
            'abudemen' => str($this->abudemen)->replace('.', '')->value(),
        ]);
    }
}
