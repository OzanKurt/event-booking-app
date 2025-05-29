@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Etkinliklerim</h1>

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

                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger" type="submit">Sil</button>
                            </form>

                            <button id="book-event-button" class="btn btn-sm btn-success" type="submit">Rezerve et</button>

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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookButton = document.getElementById('book-event-button');
            if (bookButton) {
                bookButton.addEventListener('click', function () {
                    const eventId = this.dataset.eventId;

                    fetch('/bookings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ event_id: eventId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                Swal.fire({ // Veya toastr.success(data.message)
                                    icon: 'success',
                                    title: 'Başarılı!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                // Rezervasyon yapıldıktan sonra düğmeyi devre dışı bırakma veya metnini değiştirme
                                bookButton.disabled = true;
                                bookButton.textContent = 'Rezerve Edildi';
                            } else if (data.errors) {
                                // Hata mesajlarını göster
                                let errorMessage = '';
                                for (const key in data.errors) {
                                    errorMessage += data.errors[key].join('\n') + '\n';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hata!',
                                    text: errorMessage
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Bir hata oluştu, lütfen tekrar deneyin.'
                            });
                        });
                });
            }
        });
    </script>
@endsection
