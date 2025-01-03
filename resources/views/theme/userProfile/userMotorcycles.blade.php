@extends('theme.master')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">My Motorcycles</h1>
        <!-- Button to Open Add Motorcycle Modal -->
        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addMotorcycleModal">
            Add Motorcycle
        </button>
        <!-- Add Motorcycle Modal -->
        <div class="modal fade" id="addMotorcycleModal" tabindex="-1" aria-labelledby="addMotorcycleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMotorcycleModalLabel">Add New Motorcycle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('UserMotorcycles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Hidden User ID -->
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                            <!-- Make -->
                            <div class="mb-3">
                                <label for="make" class="form-label">Make</label>
                                <input
                                    type="text"
                                    name="make"
                                    id="make"
                                    class="form-control"
                                    placeholder="Enter make"
                                    required
                                >
                            </div>

                            <!-- Model -->
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input
                                    type="text"
                                    name="model"
                                    id="model"
                                    class="form-control"
                                    placeholder="Enter model"
                                    required
                                >
                            </div>

                            <!-- Year -->
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input
                                    type="number"
                                    name="year"
                                    id="year"
                                    class="form-control"
                                    placeholder="Enter year"
                                    min="1900"
                                    max="2100"
                                    required
                                >
                            </div>

                            <!-- Price Per Day -->
                            <div class="mb-3">
                                <label for="price_per_day" class="form-label">Price Per Day</label>
                                <input
                                    type="number"
                                    name="price_per_day"
                                    id="price_per_day"
                                    class="form-control"
                                    placeholder="Enter price"
                                    min="0"
                                    required
                                >
                            </div>

                            <!-- Availability Status -->
                            <div class="mb-3">
                                <label for="availability_status" class="form-label">Availability Status</label>
                                <select name="availability_status" id="availability_status" class="form-select" required>
                                    <option value="available">Available</option>
                                    <option value="under_maintenance">Under Maintenance</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    placeholder="Enter description"
                                    rows="3"
                                ></textarea>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="form-control"
                                    required
                                >
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Add Motorcycle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($motorcycles->isEmpty())
            <div class="alert alert-info">
                You don't have any motorcycles listed yet. <a href="{{ route('motorcycles.create') }}" class="alert-link">Add a new motorcycle</a>.
            </div>
        @else
            <div class="row">
                @foreach($motorcycles as $motorcycle)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <img
                                src="{{ $motorcycle->image ? asset('storage/' . $motorcycle->image) : asset('assets/img/default-motorcycle.jpg') }}"
                                class="card-img-top"
                                alt="{{ $motorcycle->model }}"
                                style="object-fit: cover; height: 200px;"
                            >
                            <div class="card-body">
                                <!-- Inline Editing Form -->
                                <form action="{{ route('UserMotorcycles.update', $motorcycle->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Make -->
                                    <div class="mb-3">
                                        <label for="make-{{ $motorcycle->id }}" class="form-label">Make</label>
                                        <input
                                            type="text"
                                            name="make"
                                            id="make-{{ $motorcycle->id }}"
                                            class="form-control"
                                            value="{{ $motorcycle->make }}"
                                            placeholder="Enter make"
                                            required
                                        >
                                    </div>

                                    <!-- Model -->
                                    <div class="mb-3">
                                        <label for="model-{{ $motorcycle->id }}" class="form-label">Model</label>
                                        <input
                                            type="text"
                                            name="model"
                                            id="model-{{ $motorcycle->id }}"
                                            class="form-control"
                                            value="{{ $motorcycle->model }}"
                                            placeholder="Enter model"
                                            required
                                        >
                                    </div>

                                    <!-- Button to Show Details -->
                                    <button type="button" class="btn btn-primary btn-sm" onclick="toggleDetails({{ $motorcycle->id }})">
                                        Show Details
                                    </button>

                                    <!-- Hidden Fields -->
                                    <div id="details-{{ $motorcycle->id }}" style="display: none;">
                                        <!-- Year -->
                                        <div class="mb-3 mt-3">
                                            <label for="year-{{ $motorcycle->id }}" class="form-label">Year</label>
                                            <input
                                                type="number"
                                                name="year"
                                                id="year-{{ $motorcycle->id }}"
                                                class="form-control"
                                                value="{{ $motorcycle->year }}"
                                                placeholder="Enter year"
                                                min="1900"
                                                max="2100"
                                                required
                                            >
                                        </div>

                                        <!-- Price Per Day -->
                                        <div class="mb-3">
                                            <label for="price-{{ $motorcycle->id }}" class="form-label">Price Per Day</label>
                                            <input
                                                type="number"
                                                name="price_per_day"
                                                id="price-{{ $motorcycle->id }}"
                                                class="form-control"
                                                value="{{ $motorcycle->price_per_day }}"
                                                placeholder="Enter price"
                                                min="0"
                                                required
                                            >
                                        </div>

                                        <!-- Availability Status -->
                                        <div class="mb-3">
                                            <label for="status-{{ $motorcycle->id }}" class="form-label">Availability Status</label>
                                            <select name="availability_status" id="status-{{ $motorcycle->id }}" class="form-select" required>
                                                <option value="available" {{ $motorcycle->availability_status == 'available' ? 'selected' : '' }}>Available</option>
                                                <option value="under_maintenance" {{ $motorcycle->availability_status == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                            </select>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label for="description-{{ $motorcycle->id }}" class="form-label">Description</label>
                                            <textarea
                                                name="description"
                                                id="description-{{ $motorcycle->id }}"
                                                class="form-control"
                                                placeholder="Enter description"
                                                rows="3"
                                            >{{ $motorcycle->description }}</textarea>
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="mb-3">
                                            <label for="image-{{ $motorcycle->id }}" class="form-label">Image <span class="text-danger">*</span></label>
                                            <input
                                                type="file"
                                                name="image"
                                                id="image-{{ $motorcycle->id }}"
                                                class="form-control"
                                                required
                                            >
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                                    </div>
                                </form>

                                <!-- Delete Button Form (Separate Form) -->
                                <form action="{{ route('UserMotorcycles.destroy', $motorcycle->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this motorcycle?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- JavaScript to Toggle Details -->
    <script>
        function toggleDetails(id) {
            const detailsDiv = document.getElementById(`details-${id}`);
            if (detailsDiv.style.display === 'none' || detailsDiv.style.display === '') {
                detailsDiv.style.display = 'block';
            } else {
                detailsDiv.style.display = 'none';
            }
        }
    </script>
@endsection
