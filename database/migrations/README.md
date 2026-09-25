# Migration guide

Laravel uses each migration filename as its applied-migration ID. These files
have already run in this project, so keep their timestamped filenames intact;
renaming them can make Laravel attempt to run them again against an existing
database.

| File | Purpose |
| --- | --- |
| `0001_01_01_000000_create_users_table.php` | Create user accounts |
| `0001_01_01_000001_create_cache_table.php` | Create Laravel cache storage |
| `0001_01_01_000002_create_jobs_table.php` | Create Laravel queue storage |
| `2024_01_01_000001_add_phone_and_role_to_users_table.php` | Add phone and role to users |
| `2024_01_01_000002_create_parking_slots_table.php` | Create parking slots |
| `2024_01_01_000003_create_bookings_table.php` | Create bookings |
| `2026_09_25_000001_add_booking_completion_and_demo_payment.php` | Add completion and payment fields |

For new migrations, use a short purpose after Laravel's timestamp, such as
`2026_09_25_000002_add_booking_receipt.php`.
