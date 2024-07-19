<?php

namespace Modules\messenger\app\Http\Requests\MessengerUserMessage;

use Modules\messenger\app\Http\Requests\MessengerUser\FetchRequest as FetchMessengerUserRequest;

class FetchRequest extends FetchMessengerUserRequest
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
            ...parent::rules(),
            'message_id' => [
                'required',
                'numeric',
            ]
        ];
    }

    public function all($keys = null)
    {
        return array_replace_recursive([
            ...$this->input(),
            ...parent::all(),
            'message_id' => $this->route('message_id'),
        ], $this->allFiles());
    }
}
