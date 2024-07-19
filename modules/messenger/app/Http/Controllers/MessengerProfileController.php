<?php

namespace Modules\messenger\app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Modules\messenger\app\Http\Requests\MessengerProfile\UpdateActiveStatusRequest;
use Modules\messenger\app\Http\Resources\MessengerProfile\MessengerProfileResource;
use Modules\messenger\app\Services\MessengerProfileService\MessengerProfileService;

class MessengerProfileController extends Controller
{

    public function updateActiveStatus(UpdateActiveStatusRequest $updateActiveStatusRequest)
    {
        $validated_data = $updateActiveStatusRequest->validated();

        try {
            DB::beginTransaction();

            return response()->messengerJsonSuccess(
                data: MessengerProfileResource::make(resolve(MessengerProfileService::class)->updateActiveStatus(
                    activeStatus: $validated_data['active_status'],
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
