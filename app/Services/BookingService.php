<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\BookingRepository;
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

    public function create(Event $event): \App\Models\Booking
    {
        return $this->repo->create($event->id, Auth::id());
    }

    public function delete(int $id)
    {
        $booking = $this->repo->findOrFail($id);
        Gate::authorize('delete', [Auth::user(), $booking]);
        return $booking->delete();
    }
}
