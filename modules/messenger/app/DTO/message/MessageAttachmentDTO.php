<?php

namespace Modules\messenger\app\DTO\message;

use Modules\messenger\app\DTO\BaseDTO;

class MessageAttachmentDTO extends BaseDTO
{

    public string $oldName;
    public string|null $newName;

    static public function Make(
        string|null $oldName,
        string|null $newName = null,
    ) : self {
        $dto = new self;
        $dto->newName = $newName;
        $dto->oldName = $oldName;

        return $dto;
    }
}
