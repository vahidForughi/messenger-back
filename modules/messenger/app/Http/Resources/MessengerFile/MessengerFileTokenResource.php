<?php

namespace Modules\messenger\app\Http\Resources\MessengerFile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessengerFileTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token,
            'new_name' => $this->newName,
        ];
    }
}
