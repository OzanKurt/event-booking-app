<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
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

    /**
     * Rezervasyon oluşturma yetkisi
     */
    public function create(User $user, Event $event): Response
    {
        // Kullanıcılar kendi etkinliklerini rezerve edemez. [cite: 4]
        if ($user->id === $event->user_id) {
            return Response::deny('Kendi etkinliğinizi rezerve edemezsiniz.');
        }

        // Kullanıcılar aynı etkinliği iki kez rezerve edemez. [cite: 4]
        if ($event->bookings()->where('user_id', $user->id)->exists()) {
            return Response::deny('Bu etkinliği zaten rezerve ettiniz.');
        }

        return Response::allow();
    }
}
