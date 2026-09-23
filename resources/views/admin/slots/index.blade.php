@extends('layouts.app')

@section('title', 'Manage Slots')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manage Parking Slots</h3>
        <a href="{{ route('admin.slots.create') }}" class="btn btn-primary">+ Add Slot</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Slot Number</th>
                        <th>Location</th>
                        <th>Vehicle Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $slot)
                        <tr>
                            <td>{{ $slot->slot_number }}</td>
                            <td>{{ $slot->location }}</td>
                            <td>{{ $slot->vehicle_type }}</td>
                            <td>₹{{ number_format($slot->price, 2) }}</td>
                            <td>
                                @if($slot->status === 'Available')
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-warning text-dark">Booked</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.slots.edit', $slot) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('admin.slots.destroy', $slot) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this parking slot?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No parking slots available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $slots->links() }}
    </div>
@endsection
