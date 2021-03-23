<?php

declare(strict_types=1);

namespace Tipoff\Forms\Enums;

use MabeEnum\Enum;

/**
 * @method static FormType CONTACT()
 * @method static FormType EMPLOYMENT()
 * @method static FormType GROUPS()
 * @method static FormType PARTIES()
 * @method static FormType RESERVATIONS()
 * @psalm-immutable
 */
class FormType extends Enum
{
    const CONTACT = 'contact';
    const EMPLOYMENT = 'employment';
    const GROUPS = 'groups';
    const PARTIES = 'parties';
    const RESERVATIONS = 'reservations';
}
