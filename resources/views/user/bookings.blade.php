@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
    <h3 class="mb-4">My Bookings</h3>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Slot Number</th>
                        <th>Vehicle Number</th>
                        <th>Booking Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->parkingSlot->slot_number }}</td>
                            <td>{{ $booking->vehicle_number }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->start_time }}</td>
                            <td>{{ $booking->end_time }}</td>
                            <td>
                                @if($booking->status === 'Booked')
                                    <span class="badge bg-success">Booked</span>
                                @elseif($booking->status === 'Completed')
                                    <span class="badge bg-secondary">Completed</span>
                                @else
                                    <span class="badge bg-secondary">Cancelled</span>
                                @endif
                            </td>
                            <td>{{ $booking->payment_status }}<br>₹{{ number_format($booking->paid_amount, 2) }}</td>
                            <td>
                                @if($booking->status === 'Booked')
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel Booking</button>
                                    </form>
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $bookings->links() }}
    </div>
@endsection
