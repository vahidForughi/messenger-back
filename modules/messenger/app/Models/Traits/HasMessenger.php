<?php

namespace Modules\messenger\app\Models\Traits;

use Modules\messenger\app\Models\Message;

trait HasMessenger
{

    public function lastMessage()
    {
        return $this->belongsTo(
            related: Message::class,
            foreignKey: 'last_message_id',
            ownerKey: 'id',
        );
    }

    public function scopeWithLastMessage($query, $userID)
    {
        $query->addSelect([
            'last_message_id' => Message::select('id')
                ->filterForUser($userID)
                ->where(fn ($q) =>
                    $q->whereColumn('to_id', 'users.id')
                        ->orWhereColumn('from_id', 'users.id')
                )
                ->latest()
                ->take(1)
        ])->with('lastMessage');
    }

}
