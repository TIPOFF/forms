<?php

namespace Tipoff\Forms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Forms\Forms
 */
class FormsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'forms';
    }
}
