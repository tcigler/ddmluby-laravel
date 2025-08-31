<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['required', 'max:20']
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
