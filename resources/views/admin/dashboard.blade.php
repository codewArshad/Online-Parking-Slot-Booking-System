@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h3 class="mb-4">Admin Dashboard</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Slots</h6>
                    <h3>{{ $totalSlots }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Active Bookings</h6>
                    <h3 class="text-warning">{{ $bookedSlots }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Completed Bookings</h6>
                    <h3 class="text-secondary">{{ $completedBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Bookings</h6>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.slots.index') }}" class="btn btn-primary">Manage Slots</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">View Bookings</a>
    </div>
    <script>setTimeout(() => window.location.reload(), 60000);</script>
@endsection
