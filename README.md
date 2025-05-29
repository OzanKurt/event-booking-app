### Event Manager

* Authenticated users can:
  * [x] Create, edit, delete their own events
  * [x] View how many people booked an event
  * [x] See booking details on event view
* [x] Events with bookings can’t be deleted

### Booking System

* [x] Users can book any event (except their own)
* [x] Show confirmation via sweet alert or toastr

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

