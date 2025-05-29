# 🚀 Event Booking App

## Tech Stack

* Laravel 12
* Livewire
* Docker
* MySQL

## Kurulum Talimatları

Aşağıdaki tek komut projeyi çalıştırmak için yeterlidir. Proje ana dizininde çalıştırın:

```bash
  docker compose up -d --build
```

Kurulum tamamlandığında seed dosyaları otomatik olarak MySQL container'ına eklenir.

Siteye aşağıdaki linkten erişebilirsiniz:

[http://localhost:8000](http://localhost:8000)

Not: Docker ayağa kalktığında npm kurulumu devam ediyor olabilir. Siteye girmek için 30 saniye civarı beklemeniz gerekebilir (bilgisayarınızın hızına göre değişiklik gösterebilir).

## Features

### Event Manager

* Authenticated users can:
  * Create, edit, delete their own events ✅
  * View how many people booked an event ✅
  * See booking details on event view ✅
* Events with bookings can’t be deleted ✅

### Booking System

*  Users can book any event (except their own) ✅
* Show confirmation via sweet alert or toastr ✅

### Calendar View (Events Index)

* Show a read-only grid/table that lists all events ✅
* User can apply to an event from calendar. ✅
* When you click event open a new page or modal to show event details ✅
* Event details should contain booked users and there should be a book button ✅

### Policies

* EventPolicy
  * Users can't book their own ✅
  * Prevent duplicate bookings for the same user on the same event ✅
  * Cannot delete event with bookings ✅
  * User update and delete event policy ✅

* BookingPolicy
    * Users can only delete their own bookings ✅

### Validations
* EventCreateValidation ✅
* EventUpdateValidation ✅

### Middleware
* LogRequestMiddleware ✅
* AuthMiddleware ✅

### Seeders
* Veritabanı için örnek kullanıcı, etkinlik ve başvuru verileri eklenmiştir. ✅
