@extends('dashboard.layout')

@section('content')
    <div class="container">
        <h1>Edit Motorcycle</h1>

        {{-- Display success or error messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('motorcycles.update', $motorcycle->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="make">Make</label>
                <input
                    type="text"
                    class="form-control"
                    id="make"
                    name="make"
                    value="{{ old('make', $motorcycle->make) }}">
            </div>

            <div class="form-group">
                <label for="model">Model</label>
                <input
                    type="text"
                    class="form-control"
                    id="model"
                    name="model"
                    value="{{ old('model', $motorcycle->model) }}">
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <input
                    type="number"
                    class="form-control"
                    id="year"
                    name="year"
                    value="{{ old('year', $motorcycle->year) }}">
            </div>

            <div class="form-group">
                <label for="price_per_day">Price per Day</label>
                <input
                    type="number"
                    class="form-control"
                    id="price_per_day"
                    name="price_per_day"
                    value="{{ old('price_per_day', $motorcycle->price_per_day) }}"
                    step="0.01">
            </div>

            <div class="form-group">
                <label for="availability_status">Availability Status</label>
                <select class="form-control" id="availability_status" name="availability_status">
                    <option value="available" {{ old('availability_status', $motorcycle->availability_status) == 'available' ? 'selected' : '' }}>
                        Available
                    </option>
                    <option value="unavailable" {{ old('availability_status', $motorcycle->availability_status) == 'unavailable' ? 'selected' : '' }}>
                        Unavailable
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description">{{ old('description', $motorcycle->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Motorcycle Image</label>
                <input
                    type="file"
                    class="form-control"
                    id="image"
                    name="image"
                    accept="image/*">

                @if ($motorcycle->image)
                    <div class="mt-2">
                        <img
                            src="{{ asset('storage/' . $motorcycle->image) }}"
                            alt="Motorcycle Image"
                            class="img-thumbnail"
                            width="150">
                        <p class="text-muted">Current image</p>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Motorcycle</button>
        </form>
    </div>
@endsection
