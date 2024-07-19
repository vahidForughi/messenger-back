<?php

namespace Modules\messenger\app\Http\Resources\MessengerMessage;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessengerMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        dump($this->id, $this->created_at->toFormattedDateString(), $this->created_at->isToday());
        return [
            'id' => $this->id,
            'from_id' => $this->from_id,
            'from_user' => $this->from_user,
            'to_id' => $this->to_id,
            'to_user' => $this->to_user,
            'body' => $this->body,
            'attachment' => !empty($this->attachment)
                ? MessengerMessageAttachmentResource::make($this->attachment)->toArray($request)
                : null,
            'seen' => $this->seen,
            'humanized_created_at' => $this->humanizeDateTime($this->created_at),
            'created_at' => $this->created_at,
        ];
    }

    private function humanizeDateTime(Carbon $dateTime)
    {
        return match (true) {
            $dateTime->isToday() => $dateTime->toTimeString('minute'),
            $dateTime->isYesterday() => 'Yesterday',
            default => $dateTime->toFormattedDateString(),
        };
    }
}
