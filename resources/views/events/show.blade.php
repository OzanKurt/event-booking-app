@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $event->title }}</h1>
        <p><strong>Date:</strong> {{ $event->date->format('Y-m-d') }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
        <p><strong>Description:</strong> {{ $event->description }}</p>

        <h3>Bookings ({{ $event->bookings->count() }})</h3>

        @if($event->bookings->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Booking Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event->bookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No bookings yet.</p>
        @endif

        <a href="{{ route('events.index') }}" class="btn btn-secondary mt-3">Back to Events</a>
    </div>
@endsection
