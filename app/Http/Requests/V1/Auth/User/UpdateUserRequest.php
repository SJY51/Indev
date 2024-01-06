<?php

namespace App\Http\Requests\V1\Auth\User;


use App\Helpers\UserHelper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;



class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return UserHelper::isCurrentUserOrHasAccess($this->route('id'),'edit users');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'phone' => ['nullable', 'regex:/^\+\d{7,}$/'],
            'password' => 'nullable|min:8',
            'password_confirmation' => 'required_with:password|same:password|nullable|min:8',
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

        if (!empty($this->password) && !empty($this->password_confirmation)) {
            $data['password'] = bcrypt($this->password);
        } else {
            unset($data['password']);
        }
        unset($data['password_confirmation']);

        return $data;
    }

}
