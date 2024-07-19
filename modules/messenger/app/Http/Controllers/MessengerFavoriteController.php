<?php

namespace Modules\messenger\app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\messenger\app\Http\Requests\MessengerUser\IndexRequest;
use Modules\messenger\app\Http\Resources\MessengerUser\MessengerUserResource;
use Modules\messenger\app\Services\MessengerFavorite\MessengerFavoriteService;

class MessengerFavoriteController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $indexRequest->validated();

        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerUserResource::collection(resolve(MessengerFavoriteService::class)->fetchList(
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
}
