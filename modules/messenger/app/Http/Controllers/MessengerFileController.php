<?php

namespace Modules\messenger\app\Http\Controllers;

use Illuminate\Http\Request;
use Modules\messenger\app\DTO\file\MessengerFileDTO;
use Modules\messenger\app\Http\Requests\MessengerFile\UploadRequest;
use Modules\messenger\app\Http\Resources\MessengerFile\MessengerFileTokenResource;
use Modules\messenger\app\Services\MessengerFile\MessengerFileService;

class MessengerFileController extends Controller
{
    public function upload(UploadRequest $uploadRequest)
    {
        $validated_data = $uploadRequest->validated();

        return response()->messengerJsonSuccess(
            data: MessengerFileTokenResource::make(resolve(MessengerFileService::class)->upload(
                userID: $uploadRequest->user()->id,
                fileChunk: $validated_data['file_chunk'],
                isLastChunk: !empty($validated_data['is_last_chunk']) ? $validated_data['is_last_chunk'] : false,
                fileData: MessengerFileDTO::Make(
                    newName: $validated_data['name'],
                    token: $validated_data['token'],
                )
            )),
        );
    }

    public function preview(Request $request, string $path)
    {
        return resolve(MessengerFileService::class)->download(
            userID: $request->user()->id,
            path: $path,
        );
    }
}
