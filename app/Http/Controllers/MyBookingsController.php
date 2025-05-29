<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;

class MyBookingsController extends Controller
{
    /**
     * @param BookingService $service
     */
    public function __construct(
        private BookingService $service
    ){}

    public function index()
    {
        return view('my-bookings.index', ['bookings' => $this->service->getUserBookings(Auth::id())]);
    }
}
