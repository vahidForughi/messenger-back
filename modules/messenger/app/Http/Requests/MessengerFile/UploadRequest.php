<?php

namespace Modules\messenger\app\Http\Requests\MessengerFile;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'file_chunk' => [
                'required',
                'file',
                'max:10000'
            ],
            'token' => [
                'nullable',
                'required_with:name',
                'string',
            ],
            'name' => [
                'nullable',
                'string',
            ],
            'is_last_chunk' => [
                'nullable',
                'boolean',
            ],
        ];
    }

}
