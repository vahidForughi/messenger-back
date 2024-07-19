<?php

namespace Modules\messenger\app\Http\Resources\MessengerUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\messenger\app\Http\Resources\MessengerMessage\MessengerMessageResource;

class MessengerUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'active_status' => $this->active_status,
            'last_message' => !empty($this->lastMessage) ? MessengerMessageResource::make($this->lastMessage) : null,
        ];
    }
}
