@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Yaptığım Rezervasyonlar</h1>
        @if ($bookings->isEmpty())
            <p>Henüz herhangi bir etkinliğe rezervasyon yapmadınız.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Etkinlik Adı</th> <th>Konum</th> <th>Rezervasyon Tarihi</th>
                    <th>Eylemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->event->title }}</td>
                        <td>{{ $booking->event->location }}</td>
                        <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu rezervasyonu iptal etmek istediğinizden emin misiniz?')">İptal Et</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection<?php
