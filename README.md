# Online Parking Slot Booking System

A simple, beginner-friendly Laravel web application for a BCA college project.
Users can register, browse available parking slots, book a slot, and manage
their own bookings. Admins can manage parking slots and view/search all
bookings.

## Features

**User**
- Register / Login / Logout
- View available parking slots
- Book a parking slot
- View own bookings
- Cancel a booking
- View / edit profile (name, phone)

**Admin**
- Admin dashboard with slot/booking statistics
- Full CRUD on parking slots (Add / Edit / Delete)
- View all bookings
- Search bookings by slot number or vehicle number

## Technology Stack

- PHP 8.2+
- Laravel 11
- MySQL
- Blade templates
- Bootstrap 5 (via CDN)
- WAMP (Apache + MySQL on Windows)

## System Requirements

- WAMP Server (with PHP 8.2+ and MySQL)
- Composer (https://getcomposer.org)
- A code editor (VS Code recommended)

## Important note on this delivery

This zip contains all the **application-specific files** — models, migrations,
controllers, middleware, routes, Blade views, seeder, `composer.json`, and
`.env.example`. It does **not** include the Laravel framework's `vendor/`
folder, since that has to be downloaded fresh via Composer on a machine with
internet access. Follow the steps below to combine the two.

## Installation

### Step 1 — Create a fresh Laravel skeleton

Open Command Prompt, go to your WAMP `www` folder, and run:

```bash
cd C:\wamp64\www
composer create-project laravel/laravel parking-booking
```

### Step 2 — Overlay these files

Extract this zip and copy its contents **into** the `parking-booking` folder
you just created, overwriting files when prompted (it will overwrite things
like `routes/web.php`, `bootstrap/app.php`, `.env.example`, and
`composer.json`, and add the new app files — models, controllers, migrations,
views, etc.).

### Step 3 — Install dependencies

Since `composer.json` was overwritten with the pinned versions this project
needs, run:

```bash
cd parking-booking
composer install
```

### Step 4 — Create the MySQL database

1. Start WAMP, make sure the tray icon is green.
2. Open `http://localhost/phpmyadmin`.
3. Create a new database named:

```text
parking_booking
```

### Step 5 — Configure environment

Copy `.env.example` to `.env` (if it doesn't already exist):

```bash
copy .env.example .env
```

Then generate the application key:

```bash
php artisan key:generate
```

Check `.env` and confirm the database settings match your WAMP MySQL setup
(default WAMP MySQL user is usually `root` with no password):

```env
DB_DATABASE=parking_booking
DB_USERNAME=root
DB_PASSWORD=
```

### Step 6 — Run migrations and seed the database

```bash
php artisan migrate
php artisan db:seed
```

This creates the `users`, `parking_slots`, and `bookings` tables, plus a demo
admin account and a few sample parking slots.

### Step 7 — Run the project

```bash
php artisan serve
```

Open your browser to:

```text
http://127.0.0.1:8000
```

## Demo Admin Login

```text
Email:    admin@example.com
Password: Admin@123
```

**Change this password before any real deployment.**

## Laravel Version Note

This project assumes **Laravel 11**, which registers middleware aliases in
`bootstrap/app.php` (already set up in this project to register the `admin`
middleware alias). If `composer create-project laravel/laravel` on your
machine installs Laravel 10 instead, you'll need to register the alias the
Laravel 10 way instead, in `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ...existing aliases...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

Everything else (models, controllers, migrations, views, routes) works the
same on both versions.

## CRUD Explanation

**Parking Slots** (Admin only)
- Create: `admin/slots/create` → `ParkingSlotController@store`
- Read: `admin/slots` → `ParkingSlotController@index`
- Update: `admin/slots/{id}/edit` → `ParkingSlotController@update`
- Delete: `ParkingSlotController@destroy` (blocked if the slot has an active
  booking)

**Bookings**
- Create: `BookingController@store` (user books a slot)
- Read: users see their own bookings (`BookingController@myBookings`);
  admins see all bookings (`AdminController@bookings`)
- Update: `BookingController@cancel` changes status from `Booked` to
  `Cancelled` and frees the slot
- Delete: not exposed in the UI by default, to keep a full audit trail of
  cancelled bookings; can be added to `BookingController` if your viva
  requires a hard-delete demonstration

## Search Explanation

Admin can search bookings by **slot number** or **vehicle number** from
`admin/bookings?search=...`. The query uses Eloquent's `whereHas` (to search
the related parking slot's number) combined with `orWhere` on the booking's
own `vehicle_number` column — see `AdminController@bookings`.

## Testing Checklist

- [ ] Register a new user
- [ ] Login as the new user
- [ ] Login as admin (`admin@example.com` / `Admin@123`)
- [ ] Try an invalid login
- [ ] Try registering with a duplicate email
- [ ] Logout
- [ ] As a user, try visiting `/admin/dashboard` directly → should be blocked (403)
- [ ] As admin, add a new parking slot
- [ ] As admin, edit a parking slot
- [ ] As admin, try deleting a slot that has an active booking → should be blocked
- [ ] As admin, delete a slot with no active booking → should succeed
- [ ] As a user, view available slots and book one
- [ ] Confirm the booked slot no longer appears as available
- [ ] View "My Bookings" and confirm only your own bookings show
- [ ] Cancel a booking and confirm the slot becomes Available again
- [ ] As admin, search bookings by slot number
- [ ] As admin, search bookings by vehicle number
- [ ] Search for something that doesn't exist → "No matching bookings found."
- [ ] Update your profile name and phone

## Project Structure

```text
parking-booking/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminController.php
│   │   │   ├── ParkingSlotController.php
│   │   │   ├── BookingController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── ParkingSlot.php
│       └── Booking.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── home.blade.php
│       ├── auth/
│       ├── admin/
│       └── user/
├── routes/
│   └── web.php
├── bootstrap/
│   └── app.php
├── .env.example
├── composer.json
└── README.md
```
