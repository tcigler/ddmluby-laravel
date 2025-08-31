<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest {
    public function rules(): array {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'location' => ['required'],
            'program' => ['nullable'],
            'start' => ['required', 'date'],
            'end' => ['nullable', 'date'],
            'show_from' => ['required', 'date'],
            'reservation_open' => ['boolean'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
