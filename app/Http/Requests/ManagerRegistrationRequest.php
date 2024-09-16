<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRegistrationRequest extends FormRequest
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
        $roles = [
            "t_manager",
            "c_manager",
            "g_authority",
        ];
        return [
            'email'             => 'required|email|unique:users',
            'password'          => 'required',
            'name'              => 'required|string|max:100',
            'nid'               => 'required|string|unique:users',
            'phone_number'      => 'required|string|',
            'role'              => 'required|in:' . implode(',', $roles),
        ];
    }
}
