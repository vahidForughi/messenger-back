<?php

namespace Modules\messenger\app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\messenger\app\Http\Requests\MessengerUser\IndexRequest;
use Modules\messenger\app\Http\Requests\MessengerUser\ShowRequest;
use Modules\messenger\app\Http\Resources\MessengerUser\MessengerUserResource;
use Modules\messenger\app\Services\MessengerUser\MessengerUserService;

class MessengerUserController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $indexRequest->validated();
        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerUserResource::collection(resolve(MessengerUserService::class)->fetchList(
                    userID: $indexRequest->user()->id,
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

    public function show(ShowRequest $indexRequest)
    {
        $validated_data = $indexRequest->validated();

        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerUserResource::make(resolve(MessengerUserService::class)->fetch(
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

}
