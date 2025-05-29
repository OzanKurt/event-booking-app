<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function delete(User $user, Booking $booking): Response
    {
        // Sadece rezervasyonu yapan kullanıcı silebilir
        return $user->id === $booking->user_id
            ? Response::allow()
            : Response::deny('Bu rezervasyonu iptal etme yetkiniz yok.');
    }
}
