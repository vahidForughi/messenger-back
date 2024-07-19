<?php

namespace Modules\messenger\app\Http\Requests\MessengerProfile;

use Illuminate\Foundation\Http\FormRequest;
use Modules\messenger\app\Rules\UserActiveStatusRule;

class UpdateActiveStatusRequest extends FormRequest
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
            'active_status' => [
                'required',
                new UserActiveStatusRule()
            ]
        ];
    }
}
