<?php

declare(strict_types=1);

namespace Tipoff\Forms\Enums;

use Tipoff\Statuses\Models\Status;
use Tipoff\Support\Enums\BaseEnum;

/**
 * @method static ContactStatus SUBMITTED()
 * @psalm-immutable
 */
class ContactStatus extends BaseEnum
{
    const SUBMITTED = 'Submitted';

    public static function statusType(): string
    {
        return StatusType::CONTACT;
    }

    public function toStatus(): ? Status
    {
        /** @psalm-suppress ImpureMethodCall */
        return Status::findStatus(static::statusType(), (string) $this->getValue());
    }
}
