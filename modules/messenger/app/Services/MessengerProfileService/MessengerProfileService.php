<?php

namespace Modules\messenger\app\Services\MessengerProfileService;

use App\Models\User;
use Modules\messenger\app\Events\UserActiveStatusUpdated;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class MessengerProfileService
{
    public function updateActiveStatus(
        int $activeStatus,
    ): User {
        $authUser = auth()->user();

        if ($authUser->active_status != $activeStatus) {
            User::where('id', $authUser->id)->update([
                'active_status' => $activeStatus,
            ]);

            $user = User::select('id','name','avatar','active_status')->find($authUser->id);

            broadcast(new UserActiveStatusUpdated($user));

            return $user;
        }
        else{
            throw new BadRequestException('active status is updated');
        }
    }
}
