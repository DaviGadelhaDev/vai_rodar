<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ];
    }

    public function messages(): array
    {
       return [
        'name.required' => 'Nome é obrigatório',
        'email.required' => 'E-mail é obrigatório',
        'email.email' => 'E-mail inválido',
        'email.unique' => 'E-mail já cadastrado',
        'password.required' => 'Senha é obrigatória',
        'password.min' => 'O campo senha deve ter no mínimo :min caracteres'        
       ];
    }
}
