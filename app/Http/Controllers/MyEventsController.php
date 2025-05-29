<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyEventsController extends Controller
{
    /**
     * @param EventService $service
     */
    public function __construct(
        private EventService $service
    ){}

    public function index()
    {
        return view('my-events.index', ['events' => $this->service->getUserEvents(Auth::id())]);
    }
}
