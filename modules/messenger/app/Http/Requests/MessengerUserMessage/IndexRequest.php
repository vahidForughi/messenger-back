<?php

namespace Modules\messenger\app\Http\Requests\MessengerUserMessage;

use Modules\messenger\app\Http\Requests\MessengerUser\FetchRequest as FetchMessengerUserRequest;

class IndexRequest extends FetchMessengerUserRequest
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
        ];
    }
}
