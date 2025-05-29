@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rezervasyonlarım</h1>

        <div class="d-flex mb-3">
            <a href="{{ route('events.index') }}" class="btn btn-primary">Geri Dön</a>
        </div>

        @if($bookings->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Location</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->event->title }}</td>
                        <td>{{ $booking->event->location }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $bookings->links() }}
        @else
            <p>Hiç rezervasyon yok.</p>
        @endif
    </div>

@endsection

