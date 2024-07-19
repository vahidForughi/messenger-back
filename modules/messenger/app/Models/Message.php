<?php

namespace Modules\messenger\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'body',
        'attachment',
        'seen',
    ];

    protected $casts = [
        'attachment' => 'json',
        'seen' => 'boolean',
    ];


    public function scopeFilterForUser($query, $userID)
    {
        $query->where(fn ($q) =>
            $q->where('from_id', $userID)
                ->orWhere('to_id', $userID)
        );
    }

}
