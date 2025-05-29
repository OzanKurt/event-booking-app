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

                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const bookButtons = document.querySelectorAll('.book-event-button');

            bookButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const eventId = this.dataset.eventId;

                    if (!eventId) {
                        console.error('eventId yok!');
                        return;
                    }

                    fetch('/bookings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ event_id: eventId })
                    })
                        .then(async response => {
                            if (!response.ok) {
                                // Hata durumları: 403, 422, 500 vb.
                                if (response.status === 403) {
                                    throw new Error('Bu etkinliğe daha önce rezervasyon oluşturmuşsunuz.');
                                } else if (response.status === 422) {
                                    const errorData = await response.json();
                                    throw new Error(Object.values(errorData.errors).flat().join('\n'));
                                } else {
                                    throw new Error('Beklenmeyen bir hata oluştu.');
                                }
                            }

                            return response.json();
                        })
                        .then(data => {
                            if (data.message) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Başarılı!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                button.disabled = true;
                                button.textContent = 'Rezerve Edildi';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: error.message || 'Bir hata oluştu, lütfen tekrar deneyin.'
                            });
                        });
                });
            });
        });
    </script>
@endpush
