<?php

namespace Modules\messenger\app\Services\MessengerFile;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\messenger\app\DTO\file\MessengerFileDTO;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessengerFileService
{
    public function upload(
        int                   $userID,
        UploadedFile          $fileChunk,
        bool                  $isLastChunk,
        MessengerFileDTO|null $fileData = null,
    ): MessengerFileDTO
    {
        $fileExtension = pathinfo(basename($fileChunk->getClientOriginalName(), '.part'), PATHINFO_EXTENSION);

        if (empty($fileData) || empty($fileData->newName)) {
            $new_name = Str::uuid() . (!empty($fileExtension) ? '.' . $fileExtension : '');
        } else {
            if (!$fileData->checkToken($userID)) {
                throw new NotFoundHttpException('token not valid!');
            }

            $new_name = $fileData->newName;
        }

        Storage::disk('s3')->append($temp_path = "temp/{$new_name}.part", $fileChunk->get());

        if ($isLastChunk) {
            Storage::disk('s3')->move($temp_path, "{$new_name}");
        }

        return MessengerFileDTO::Make(
            newName: $new_name,
            token: MessengerFileDTO::generateToken($userID, $new_name),
        );
    }

    public function download(
        int $userID,
        string $path,
    ) {
        if (!Storage::disk('s3')->exists($path)) {
            throw new NotFoundHttpException('file not found!');
        }

        return Storage::disk('s3')->response($path);
    }

    public function moveToTrash(
        string $path,
    ): void{
        if (!Storage::disk('s3')->exists($path)) {
            throw new NotFoundHttpException('file not found!');
        }

        Storage::disk('s3')->move($path, '/trash/' . basename($path));
    }

}
