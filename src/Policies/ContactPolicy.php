<?php

declare(strict_types=1);

namespace Tipoff\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Forms\Models\Contact;
use Tipoff\Support\Contracts\Models\UserInterface;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view contacts') ? true : false;
    }

    public function view(UserInterface $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('view contacts') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create contacts') ? true : false;
    }

    public function update(UserInterface $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('update contacts') ? true : false;
    }

    public function delete(UserInterface $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('delete contacts') ? true : false;
    }

    public function restore(UserInterface $user, Contact $contact): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Contact $contact): bool
    {
        return false;
    }
}
