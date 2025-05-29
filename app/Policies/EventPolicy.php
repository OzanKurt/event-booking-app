<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    public function view(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function update(User $user, Event $event)
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event)
    {
        if ($event->bookings()->count() > 0) {
            return Response::deny('Cannot delete event with bookings.');
        }

        return $user->id === $event->user_id;
    }
}
