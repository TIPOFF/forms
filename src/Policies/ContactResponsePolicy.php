<?php

declare(strict_types=1);

namespace Tipoff\Forms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Forms\Models\ContactResponse;
use Tipoff\Support\Contracts\Models\UserInterface;

class ContactResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user): bool
    {
        return $user->hasPermissionTo('view contact responses') ? true : false;
    }

    public function view(UserInterface $user, ContactResponse $contact_response): bool
    {
        return $user->hasPermissionTo('view contact responses') ? true : false;
    }

    public function create(UserInterface $user): bool
    {
        return $user->hasPermissionTo('create contact responses') ? true : false;
    }

    public function update(UserInterface $user, ContactResponse $contact_response): bool
    {
        return $user->hasPermissionTo('update contact responses') ? true : false;
    }

    public function delete(UserInterface $user, ContactResponse $contact_response): bool
    {
        return $user->hasPermissionTo('delete contact responses') ? true : false;
    }

    public function restore(UserInterface $user, ContactResponse $contact_response): bool
    {
        return false;
    }

    public function forceDelete(UserInterface $user, ContactResponse $contact_response): bool
    {
        return false;
    }
}
