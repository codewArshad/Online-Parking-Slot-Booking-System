@extends('layouts.app')

@section('title', 'Add Slot')

@section('content')
    <h3 class="mb-4">Add Parking Slot</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.slots.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Slot Number</label>
                    <input type="text" name="slot_number" value="{{ old('slot_number') }}" placeholder="e.g. A-01"
                           class="form-control @error('slot_number') is-invalid @enderror" required>
                    @error('slot_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Ground Floor"
                           class="form-control @error('location') is-invalid @enderror" required>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Type</label>
                    <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                        <option value="">-- Select --</option>
                        <option value="Car" {{ old('vehicle_type') === 'Car' ? 'selected' : '' }}>Car</option>
                        <option value="Bike" {{ old('vehicle_type') === 'Bike' ? 'selected' : '' }}>Bike</option>
                        <option value="Both" {{ old('vehicle_type') === 'Both' ? 'selected' : '' }}>Both</option>
                    </select>
                    @error('vehicle_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                           class="form-control @error('price') is-invalid @enderror" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Available" {{ old('status') === 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Booked" {{ old('status') === 'Booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Slot</button>
                <a href="{{ route('admin.slots.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
