<?php

namespace App\Http\Requests\Admin\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'max:255|unique:users',
            'password' => 'bail',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => blank($this->username) ? $this->email : $this->username,
            'password' => bcrypt(blank($this->password) ? $this->username : $this->password),
        ]);
    }
}
