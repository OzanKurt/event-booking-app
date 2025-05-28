<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Kullanıcı giriş zorunlu
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Etkinlikleri listeler (sadece kullanıcı kendi etkinliklerini görür)
    public function index()
    {
        $events = Auth::user()->events()->withCount('bookings')->paginate(10);
        return view('events.index', compact('events'));
    }

    // Yeni etkinlik oluşturma sayfası
    public function create()
    {
        return view('events.create');
    }

    // Yeni etkinlik kaydetme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $event = new Event($validated);
        $event->user_id = Auth::id();
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
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
