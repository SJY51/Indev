<?php

namespace App\Http\Requests\V1\Auth\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'phone' => ['required', 'regex:/^\+\d{7,}$/'],
            'password' => 'required|confirmed|min:8',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param string|null $key
     * @param mixed $default
     *
     * @return array
     * @throws ValidationException
     */
    public function validated($key = null, $default = null): array
    {
        $data = $this->validator->validated();

        if (! empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }
        return $data;
    }

}
