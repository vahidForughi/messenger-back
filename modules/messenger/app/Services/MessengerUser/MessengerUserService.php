<?php

namespace Modules\messenger\app\Services\MessengerUser;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\messenger\app\Models\Message;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessengerUserService
{
    public function fetchList(
        int $userID
    ){
        $last_messages = Message::query()
            ->filterForUser($userID)
            ->select('from_id', 'to_id', DB::raw('MAX(created_at) as latest_message'))
            ->groupBy('from_id','to_id')
            ->orderBy('latest_message', 'desc')
            ->paginate(15);

        $usersIDs = $last_messages->select('from_id', 'to_id')
            ->flatten()
            ->unique()
            ->toArray();

        return User::select(
            'id',
            'name',
            'messenger_color',
            'dark_mode',
            'active_status',
        )
        ->whereIn('id', $usersIDs)
        ->withLastMessage($userID)
        ->get()
        ->sortBy(fn ($user) =>
            array_search($user->id, $usersIDs, false)
        );
    }

    public function fetch(
        int $messengerUserID
    ): User
    {
        if (empty($messengerUser = User::select(
            'id',
            'name',
            'avatar',
            'active_status',
        )->find($messengerUserID))) {
            throw new NotFoundHttpException('messenger user not found');
        }

        return $messengerUser;
    }
}
