@extends('theme.master')

@section('hero-title', 'User Motorcycles')

@section('content')


    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Motorcycles</h1>
            <!-- Button to Open Add Motorcycle Modal -->
            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMotorcycleModal">Add Motorcycle</a>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="addMotorcycleModal" tabindex="-1" aria-labelledby="addMotorcycleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMotorcycleModalLabel">Add New Motorcycle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Motorcycle Form -->
                        <form id="motorcycleForm" action="{{ route('UserMotorcycles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="make" class="form-label">Make</label>
                                    <input type="text" name="make" id="make" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" name="model" id="model" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" name="year" id="year" class="form-control" min="1900" max="2100" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="price_per_day" class="form-label">Price Per Day</label>
                                    <input type="number" name="price_per_day" id="price_per_day" class="form-control" min="0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="availability_status" class="form-label">Availability Status</label>
                                <select name="availability_status" id="availability_status" class="form-select" required>
                                    <option value="available">Available</option>
                                    <option value="under_maintenance">Under Maintenance</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg+xml" required>
                                <div id="imageError" class="text-danger" style="display:none;">Please upload a valid image file (jpeg, png, jpg, gif, svg) and ensure it's less than 2MB.</div>
                            </div>

                            <button type="submit" class="btn btn-success">Add Motorcycle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional: Client-side form validation -->
        <script>
            document.getElementById('motorcycleForm').addEventListener('submit', function(event) {
                let form = event.target;
                let isValid = true;

                // Check if all required fields are filled
                form.querySelectorAll('input[required], textarea[required], select[required]').forEach(function(input) {
                    if (!input.value) {
                        isValid = false;
                        input.classList.add('is-invalid'); // Highlight invalid field
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                // Validate image file
                const imageInput = document.getElementById('image');
                const imageError = document.getElementById('imageError');
                const file = imageInput.files[0];

                if (file) {
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                    if (!validTypes.includes(file.type)) {
                        isValid = false;
                        imageError.textContent = 'Please upload a valid image file (jpeg, png, jpg, gif, svg).';
                        imageError.style.display = 'block';
                    } else if (file.size > 2048 * 1024) { // 2MB size limit
                        isValid = false;
                        imageError.textContent = 'Image file should not be larger than 2MB.';
                        imageError.style.display = 'block';
                    } else {
                        imageError.style.display = 'none';
                    }
                } else {
                    isValid = false;
                    imageError.textContent = 'Please upload an image.';
                    imageError.style.display = 'block';
                }

                // Prevent form submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                    alert('Please fill out all required fields and ensure the image is valid.');
                }
            });

        </script>

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
                                <form action="{{ route('UserMotorcycles.destroy', $motorcycle->id) }}" method="POST" class="mt-2" id="deleteForm-{{ $motorcycle->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $motorcycle->id }})">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $motorcycles->links() }}
        </div>
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form to delete the motorcycle
                    document.getElementById(`deleteForm-${id}`).submit();
                }
            });
        }
        // Get the modal and button elements
        const modal = new bootstrap.Modal(document.getElementById('addMotorcycleModal'));
        const openModalBtn = document.getElementById('openModalBtn');

        // When the button is clicked, open the modal
        openModalBtn.addEventListener('click', function() {
            modal.show();
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
