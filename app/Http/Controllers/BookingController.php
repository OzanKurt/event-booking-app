<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateValidation;
use App\Models\Booking;
use App\Repositories\EventRepository;
use App\Services\BookingService;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    /**
     * @param BookingService $service
     */
    public function __construct(
        private BookingService $service
    ){}

    public function store(BookingCreateValidation $request)
    {
        $data = $request->validated();
        $event = (new EventRepository())->findOrFail($data['event_id']);
        Gate::authorize('create', $event);

        $booking = $this->service->create($event);
        return response()->json(['message' => 'Etkinlik başarıyla rezerve edildi!', 'booking' => $booking], 201);
    }

    public function destroy(Booking $booking)
    {
        Gate::authorize('delete', $booking);

        $booking->delete();

        return redirect()->route('events.index')->with('success', 'Rezervasyon silindi.');
    }
}
