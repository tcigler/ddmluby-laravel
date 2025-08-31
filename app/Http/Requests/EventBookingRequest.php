<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventBookingRequest extends FormRequest {
    public function rules(): array {
        return [
            'event_time_slot_id' => ['required', 'exists:event_time_slots,id'],
            'user_info_id' => ['sometimes', 'nullable', 'exists:user_info,id'],
            'note' => ['nullable'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
