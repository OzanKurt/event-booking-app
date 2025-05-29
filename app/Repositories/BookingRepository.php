<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Event;

class BookingRepository
{
    public function create(int $eventId, int $userId): Booking
    {
        return Booking::create([
            'event_id' => $eventId,
            'user_id' => $userId,
        ]);
    }

    public function findOrFail(int $id)
    {
        return Booking::findOrFail($id);
    }
}
