<?php

namespace Modules\messenger\app\DTO\file;

use Illuminate\Support\Facades\Hash;
use Modules\messenger\app\DTO\BaseDTO;

class MessengerFileDTO extends BaseDTO
{

    public string|null $oldName;
    public string|null $newName;
    public string|null $token;

    static public function Make(
        string|null $oldName = null,
        string|null $newName = null,
        string|null $token = null,
    ) : self {
        $dto = new self;
        $dto->oldName = $oldName;
        $dto->newName = $newName;
        $dto->token = $token;

        return $dto;
    }

    static public function generateToken($key, $newName): string
    {
        return Hash::make($key . $newName);
    }

    public function checkToken($key): bool
    {
        return Hash::check($key . $this->newName, $this->token);
    }

}
