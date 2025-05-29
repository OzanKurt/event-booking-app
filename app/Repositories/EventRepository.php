<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventRepository
{
    public function getAuthEvents()
    {
        return Auth::user()->events()->withCount('bookings')->paginate(10);
    }

    public function create(array $params)
    {
        $event = new Event($params);
        $event->user_id = Auth::id();
        return $event->save();
    }
}
