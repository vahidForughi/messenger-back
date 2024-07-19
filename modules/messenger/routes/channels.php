<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::channel('Messenger', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'avatar' => $user->avatar,
        'active_status' => $user->active_status,
    ];
});

Broadcast::channel('Messenger.Room.{minor_id}-{major_id}', function ($user, $minorId, $majorID) {
    return Auth::check();
});


Broadcast::channel('Messenger.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
