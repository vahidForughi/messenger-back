<?php

namespace Modules\messenger\app\Http\Resources\MessengerProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessengerProfileResource extends JsonResource
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
        ];
    }
}
