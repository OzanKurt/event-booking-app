<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateValidation;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    /**
     * @param EventService $service
     */
    public function __construct(
        private EventService $service
    ){}

    public function index()
    {
        return view('events.index', ['events' => $this->service->getEvents()]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(EventCreateValidation $request)
    {
        try {
            $this->service->create($request->validated());

            return redirect()->route('events.index')
                ->with('success', 'Etkinlik başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            return redirect()->route('events.index')
                ->with('error', $e->getMessage());
        }
    }

    public function show(Event $event)
    {
        $event->load('bookings.user');

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        Gate::authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    public function update(EventCreateValidation $request, Event $event)
    {
        Gate::authorize('update', $event);

        $event->update($request->validated());

        return redirect()->route('events.index')->with('success', 'Etkinlik güncellendi.');
    }

    public function destroy(Event $event)
    {
        Gate::authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Etkinlik silindi.');
    }
}
