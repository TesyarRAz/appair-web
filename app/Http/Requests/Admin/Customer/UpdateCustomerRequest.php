<?php

namespace App\Http\Requests\Admin\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'kubik' => 'required|integer|min:0',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'bail',
        ];
    }

    protected function passedValidation()
    {
        if (blank($this->password))
            $this->offsetUnset('password');
    }
}
