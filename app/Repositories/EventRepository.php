<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventRepository
{
    public function getEvents()
    {
        return Event::withCount('bookings')->paginate(10);
    }

    public function create(array $params)
    {
        $event = new Event($params);
        $event->user_id = Auth::id();
        return $event->save();
    }

    public function findOrFail(int $eventId)
    {
        return Event::findOrFail($eventId);
    }
}
