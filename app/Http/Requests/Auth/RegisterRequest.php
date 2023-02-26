<?php

namespace App\Http\Requests\Auth;

use App\Enum\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'platform' => 'required|in:web,android,ios',
            'fcm_token' => 'required_if:platform,android,ios|string',
            'role' => ['required', new Enum(UserRoles::class)],
        ];
    }
}
