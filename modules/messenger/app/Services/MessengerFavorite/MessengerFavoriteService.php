<?php

namespace Modules\messenger\app\Services\MessengerFavorite;

use App\Models\User;
use Modules\messenger\app\Models\Favorite;

class MessengerFavoriteService
{
    private const SUPPORT_EMAIL_ADDRESS = 'support@prodmee.com';

    public function fetchList(
        int $userID
    )
    {
        return Favorite::select(
                'favorites.user_id',
                'favorites.favorite_id',
                'users.id',
                'users.name',
                'users.avatar',
                'users.active_status',
            )
            ->where('user_id', $userID)
            ->rightJoin('users', 'favorites.favorite_id', 'users.id')
            ->get()
            ->collect()
            ->merge(
                User::select(
                        'users.id',
                        'users.name',
                        'users.avatar',
                        'users.email',
                        'users.active_status',
                    )
                    ->where('id', $userID)
                    ->orWhere('email', self::SUPPORT_EMAIL_ADDRESS)
                    ->get()
            );
    }
}
