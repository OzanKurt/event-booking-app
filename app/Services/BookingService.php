<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookingService
{
    /**
     * @param BookingRepository $repo
     */
    public function __construct(
        private BookingRepository $repo
    ){}

    public function create(int $eventId): \App\Models\Booking
    {
        $event = (new EventRepository())->findOrFail($eventId);
        Gate::authorize('create', [$event, Auth::user()]);
        return $this->repo->create($event->id, Auth::id());
    }

    public function delete(int $id)
    {
        $booking = $this->repo->findOrFail($id);
        Gate::authorize('delete', [Auth::user(), $booking]);
        return $booking->delete();
    }
}
