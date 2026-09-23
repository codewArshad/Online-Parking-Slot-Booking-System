@extends('layouts.app')

@section('title', 'All Bookings')

@section('content')
    <h3 class="mb-4">All Bookings</h3>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ $search }}" class="form-control"
                   placeholder="Search by slot number or vehicle number">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Slot Number</th>
                        <th>Vehicle Number</th>
                        <th>Booking Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->user->email }}</td>
                            <td>{{ $booking->parkingSlot->slot_number }}</td>
                            <td>{{ $booking->vehicle_number }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->start_time }}</td>
                            <td>{{ $booking->end_time }}</td>
                            <td>
                                @if($booking->status === 'Booked')
                                    <span class="badge bg-success">Booked</span>
                                @else
                                    <span class="badge bg-secondary">Cancelled</span>
                                @endif
                            </td>
                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                {{ $search ? 'No matching bookings found.' : 'No bookings found.' }}
                            </td>
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
