@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Etkinlikler</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Etkinlik Oluştur</a>

        @if($events->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Bookings Count</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></td>
                        <td class="text-nowrap">{{ $event->date }}</td>
                        <td>{{ $event->location }}</td>
                        <td >{{ $event->bookings_count }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Düzenle</a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger" type="submit">Sil</button>
                            </form>

                            <button class="book-event-button btn btn-sm btn-success" type="submit" data-event-id="{{ $event->id }}">Rezerve et</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $events->links() }}
        @else
            <p>No events found.</p>
        @endif
    </div>

@endsection

@include('components.scripts.booking-script')
