<?php

namespace Modules\messenger\app\Services\MessengerUserMessage;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use Modules\messenger\app\DTO\file\MessengerFileDTO;
use Modules\messenger\app\DTO\message\MessageAttachmentDTO;
use Modules\messenger\app\Events\MessageDeletedEvent;
use Modules\messenger\app\Events\MessageSentEvent;
use Modules\messenger\app\Http\Resources\MessengerMessage\MessengerMessageResource;
use Modules\messenger\app\Models\Message;
use Modules\messenger\app\Notifications\MessageSentNotification;
use Modules\messenger\app\Services\MessengerFile\MessengerFileService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessengerUserMessageService
{
    public function fetchList(
        int $userID,
        int $messengerUserID
    ): array|LengthAwarePaginator {
        if (!User::where('id', $messengerUserID)->exists()) {
            throw new NotFoundHttpException('messenger user not found');
        }

        Message::where('to_id', $userID)
            ->where('seen', false)
            ->update([
                'seen' => true
            ]);

        return Message::where(fn ($query) =>
                $query->where('from_id', $userID)
                    ->where('to_id', $messengerUserID)
            )->orWhere(fn ($query) =>
                $query->where('from_id', $messengerUserID)
                    ->where('to_id', $userID)
            )
            ->orderby('created_at', 'desc')
            ->paginate(20);
    }

    public function store(
        int $userID,
        int $messengerUserID,
        string|null $body = null,
        MessengerFileDTO|null $attachmentFileData = null,
    ): Message {
        if (!$users = User::select('id','name','avatar','active_status')
                ->whereIn('id', [$userID ,$messengerUserID])->get()) {
            throw new NotFoundHttpException('user not found');
        }

        if (!empty($attachmentFileData) && !$attachmentFileData->checkToken($userID)) {
            throw new BadRequestHttpException('token not valid!');
        }

        $message = Message::create([
            'from_id' => $userID,
            'to_id' => $messengerUserID,
            'body' => $body,
            'attachment' => !empty($attachmentFileData) ? MessageAttachmentDTO::Make(
                oldName: $attachmentFileData->oldName,
                newName: $attachmentFileData->newName,
            )->toArray() : null,
            'seen' => false,
        ]);

        $message->from_user = $users->where('id', $userID)->first();
        $message->to_user = $users->where('id', $messengerUserID)->first();

        event(new MessageSentEvent(MessengerMessageResource::make($message)));

        Notification::send($message->to_user, new MessageSentNotification($message));

        return $message;
    }

    public function fetch(
        int $userID,
        int $messageID,
    ): Message {
        if (!empty($message = Message::where(fn ($query) =>
                    $query->where('from_id', $userID)
                        ->where('to_id', $userID)
                )
                ->find($messageID))
        ) {
            throw new NotFoundHttpException('message not found');
        }

        return $message;
    }

    public function delete(
        int $userID,
        int $messengerUserID,
        int $messageID,
    ): bool {
        if (empty($message = Message::where('from_id', $userID)->where('to_id', $messengerUserID)->find($messageID))) {
            throw new NotFoundHttpException('message not found');
        }

        if (!$message->delete()) {
            throw new NotFoundHttpException('can not delete message');
        }

        if (!empty($message->attachment)) {
            resolve(MessengerFileService::class)->moveToTrash($message->attachment['new_name']);
        }

        event(new MessageDeletedEvent($messageID, $message->to_id));

        return true;
    }
}
