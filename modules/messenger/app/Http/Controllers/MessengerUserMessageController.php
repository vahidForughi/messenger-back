<?php

namespace Modules\messenger\app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\messenger\app\DTO\file\MessengerFileDTO;
use Modules\messenger\app\Http\Requests\MessengerUserMessage\DeleteRequest;
use Modules\messenger\app\Http\Requests\MessengerUserMessage\IndexRequest;
use Modules\messenger\app\Http\Requests\MessengerUserMessage\StoreRequest;
use Modules\messenger\app\Http\Requests\MessengerUserMessage\UploadAttachmentRequest;
use Modules\messenger\app\Http\Resources\MessengerMessage\MessengerMessageResource;
use Modules\messenger\app\Services\MessengerUserMessage\MessengerUserMessageService;

class MessengerUserMessageController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $validated_data = $indexRequest->validated();

        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerMessageResource::collection(resolve(MessengerUserMessageService::class)->fetchList(
                    userID: $indexRequest->user()->id,
                    messengerUserID: $validated_data['messenger_user_id'],
                )),
            );
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        finally {
            DB::commit();
        }
    }

    public function store(StoreRequest $storeRequest)
    {
        $validated_data = $storeRequest->validated();

        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerMessageResource::make(resolve(MessengerUserMessageService::class)->store(
                    userID: $storeRequest->user()->id,
                    messengerUserID: $validated_data['messenger_user_id'],
                    body: !empty($validated_data['body']) ? $validated_data['body'] : null,
                    attachmentFileData: !empty($validated_data['attachment']) ? MessengerFileDTO::Make(
                        oldName: $validated_data['attachment']['old_name'],
                        newName: $validated_data['attachment']['new_name'],
                        token: $validated_data['attachment']['token'],
                    ) : null,
                )),
            );
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        finally {
            DB::commit();
        }
    }

    public function distroy(DeleteRequest $deleteRequest)
    {
        $validated_data = $deleteRequest->validated();

        try {
            DB::beginTransaction();

            resolve(MessengerUserMessageService::class)->delete(
                    userID: $deleteRequest->user()->id,
                    messengerUserID: $validated_data['messenger_user_id'],
                    messageID: $validated_data['message_id'],
            );
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        finally {
            DB::commit();
        }

        return response()->messengerJsonSuccess(
            data: ''
        );
    }

}
