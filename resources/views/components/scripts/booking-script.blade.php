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
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ event_id: eventId })
                    })
                        .then(async response => {
                            if (!response.ok) {
                                if (response.status === 403) {
                                    const errorData = await response.json(); // JSON içeriğini al
                                    throw new Error(errorData.message || 'Yetkisiz işlem.');
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
