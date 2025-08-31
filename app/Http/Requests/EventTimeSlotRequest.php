<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventTimeSlotRequest extends FormRequest {
    public function rules(): array {
        return [
            'event_id' => ['required', 'exists:events'],
            'time' => ['required', 'date'],
            'capacity' => ['required', 'integer'],
            'blocked' => ['boolean'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
