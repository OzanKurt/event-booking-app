@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $event->title }}</h1>
        <p><strong>Date:</strong> {{ $event->date }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
        <p><strong>Description:</strong> {{ $event->description }}</p>

        <h3>Rezervasyonlar ({{ $event->bookings->count() }})</h3>

        @if($event->bookings->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>İsim</th>
                    <th>Oluşturulma Tarihi</th>
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
            <p>Henüz rezervasyon yok.</p>
        @endif

        <div class="d-flex">
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Etkinliklere geri dön</a>
            <button class="book-event-button btn btn-success ms-2" type="button" data-event-id="{{ $event->id }}">Rezerve et</button>
        </div>
    </div>
@endsection

@include('components.scripts.booking-script')
