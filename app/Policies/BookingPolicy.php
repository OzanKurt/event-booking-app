<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
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

    /**
     * Rezervasyon silme yetkisi
     */
    public function delete(User $user, Booking $booking): Response
    {
        // Sadece rezervasyonu yapan kullanıcı silebilir
        return $user->id === $booking->user_id
            ? Response::allow()
            : Response::deny('Bu rezervasyonu iptal etme yetkiniz yok.');
    }
}
