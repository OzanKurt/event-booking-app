### Event Manager

* Authenticated users can:
  * [x] Create, edit, delete their own events
  * [x] View how many people booked an event
  * [x] See booking details on event view
* [x] Events with bookings can’t be deleted

### Booking System

* [x] Users can book any event (except their own)
* [x] Show confirmation via sweet alert or toastr

### Calendar View (Events Index)

* [x] Show a read-only grid/table that lists all events
* [x] User can apply to an event from calendar.
* [x] When you click event open a new page or modal to show event details
* [x] Event details should contain booked users and there should be a book
  button

### Policies

* EventPolicy
  * [x] Users can't book their own
  * [x] Prevent duplicate bookings for the same user on the same event
  * [x] Cannot delete event with bookings
  * [x] User update and delete event policy

* BookingPolicy
    * [x] Users can only delete their own bookings

### Validations
* [x] EventCreateValidation
* [x] EventUpdateValidation

### Middleware
* [x] LogRequestMiddleware
* [x] AuthMiddleware

### Seeders
* [x] DB Seeders
