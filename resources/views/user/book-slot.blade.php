@extends('layouts.app')

@section('title', 'Book a Slot')

@section('content')
    <h3 class="mb-4">Available Parking Slots</h3>

    <div class="row g-3">
        @forelse($slots as $slot)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $slot->slot_number }}</h5>
                        <p class="mb-1"><strong>Location:</strong> {{ $slot->location }}</p>
                        <p class="mb-1"><strong>Vehicle Type:</strong> {{ $slot->vehicle_type }}</p>
                        <p class="mb-2"><strong>Hourly rate:</strong> &#8377;{{ number_format($slot->price, 2) }}</p>
                        <span class="badge bg-success mb-3">Available</span>
                        <div>
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookModal{{ $slot->id }}">
                                Book
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bookModal{{ $slot->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('bookings.store') }}" data-hourly-rate="{{ $slot->price }}">
                            @csrf
                            <input type="hidden" name="parking_slot_id" value="{{ $slot->id }}">

                            <div class="modal-header">
                                <h5 class="modal-title">Book Slot {{ $slot->slot_number }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Vehicle Number</label>
                                    <input type="text" name="vehicle_number" class="form-control" placeholder="e.g. GJ05AB1234" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control" min="{{ now()->toDateString() }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Estimated payment</label>
                                    <div class="form-control bg-light" data-payment-estimate>Choose start and end times</div>
                                    <small class="text-muted">Charged at &#8377;{{ number_format($slot->price, 2) }} per hour. Payment is simulated; no real charge is made.</small>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Pay &amp; Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No parking slots available.</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $slots->links() }}
    </div>

    <script>
        document.querySelectorAll('form[data-hourly-rate]').forEach((form) => {
            const start = form.querySelector('[name="start_time"]');
            const end = form.querySelector('[name="end_time"]');
            const estimate = form.querySelector('[data-payment-estimate]');
            const rate = Number(form.dataset.hourlyRate);

            const updateEstimate = () => {
                if (!start.value || !end.value) {
                    estimate.textContent = 'Choose start and end times';
                    return;
                }

                const [startHour, startMinute] = start.value.split(':').map(Number);
                const [endHour, endMinute] = end.value.split(':').map(Number);
                const minutes = (endHour * 60 + endMinute) - (startHour * 60 + startMinute);

                if (minutes <= 0) {
                    estimate.textContent = 'End time must be after start time';
                    return;
                }

                const amount = rate * minutes / 60;
                estimate.textContent = `\u20B9${amount.toFixed(2)} (${(minutes / 60).toFixed(2)} hours)`;
            };

            start.addEventListener('input', updateEstimate);
            end.addEventListener('input', updateEstimate);
        });
    </script>
@endsection
