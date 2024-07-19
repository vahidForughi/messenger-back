<?php

namespace Modules\messenger\app\Http\Requests\MessengerUserMessage;

use Modules\messenger\app\Http\Requests\MessengerUser\FetchRequest as FetchMessengerUserRequest;

class StoreRequest extends FetchMessengerUserRequest
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
            'body' => [
                'required_without:attachment',
                'string',
                'max:5000',
            ],
            'attachment' => [
                'nullable',
                'required_array_keys:old_name,new_name,token'
            ],
            'attachment.old_name' => [
                'nullable',
                'string'
            ],
            'attachment.new_name' => [
                'nullable',
                'string'
            ],
            'attachment.token' => [
                'nullable',
                'string'
            ],
        ];
    }
}
