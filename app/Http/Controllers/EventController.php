<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

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
        return view('events.index', ['events' => $this->service->getAuthEvents()]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(EventCreateRequest $request)
    {
        try {
            $this->service->create($request->validated());

            return redirect()->route('events.index')
                ->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('events.index')
                ->with('error', $e->getMessage());
        }
    }

    // Etkinlik detayları (rezervasyonları ve sayısını gösterir)
    public function show(Event $event)
    {
        // Sadece etkinlik sahibi görebilir
        $this->authorize('view', $event);

        $event->load('bookings.user'); // rezervasyon yapan kullanıcı bilgileriyle birlikte

        return view('events.show', compact('event'));
    }

    // Etkinlik düzenleme sayfası
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    // Etkinlik güncelleme
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    // Etkinlik silme
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->bookings()->count() > 0) {
            return redirect()->route('events.index')->with('error', 'Cannot delete event with bookings.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
