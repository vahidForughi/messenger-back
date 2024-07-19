<?php

namespace Modules\messenger\app\Http\Resources\MessengerMessage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\MimeTypes;

class MessengerMessageAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'old_name' => $this['old_name'],
            'new_name' => $this['new_name'],
            'preview_url' => url("/messenger-files/preview/{$this['new_name']}"),
            'mimetype' => (new MimeTypes())->getMimeTypes(pathinfo($this['new_name'], PATHINFO_EXTENSION))[0],
            'size' => Storage::disk('s3')->size($this['new_name']),
        ];
    }
}
