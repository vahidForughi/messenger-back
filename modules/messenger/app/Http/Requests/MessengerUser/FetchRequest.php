<?php

namespace Modules\messenger\app\Http\Requests\MessengerUser;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
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
            'messenger_user_id' => [
                'required',
                'numeric',
            ]
        ];
    }

    public function all($keys = null)
    {
        return array_replace_recursive([
            ...$this->input(),
            'messenger_user_id' => $this->route('messenger_user_id'),
        ], $this->allFiles());
    }
}
