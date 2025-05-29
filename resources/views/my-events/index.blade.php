@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Kendi Etkinliklerim</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Yeni Etkinlik Oluştur</a>

        @if ($events->isEmpty())
            <p>Henüz oluşturduğunuz bir etkinlik yok.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Tarih</th>
                    <th>Rezervasyon Sayısı</th> <th>Eylemler</th> </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td> <td>{{ $event->date->format('d.m.Y') }}</td> <td>{{ $event->bookings_count }}</td>
                        <td>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-info btn-sm">Görüntüle</a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-warning btn-sm">Düzenle</a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu etkinliği silmek istediğinizden emin misiniz?')">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
