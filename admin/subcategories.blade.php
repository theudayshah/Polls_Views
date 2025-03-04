@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">Subcategories for {{ $category->title }}</h1>
            <button class="btn btn-gradient btn-sm mt-3 rounded-pill" data-bs-toggle="modal"
                data-bs-target="#createSubcategoryModal">
                Create Subcategory
            </button>
            <a class="btn btn-outline-secondary rounded-pill mt-3 px-4 py-2" href="{{ route('admin.home') }}">
                Go Back
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($subcategories->isEmpty())
            <p class="text-center text-muted">No subcategories available.</p>
        @else
            <div class="row g-4">
                @foreach ($subcategories as $subcategory)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-lg overflow-hidden rounded-4 hover-scale">
                            @if ($subcategory->thumbnail)
                                <span class="d-block">
                                    <img src="{{ asset('storage/' . $subcategory->thumbnail) }}" class="card-img-top"
                                        alt="{{ $subcategory->title }}" style="height: 220px; object-fit: cover;">
                                </span>
                            @endif
                            <div class="card-body text-center p-4">
                                <h5 class="fw-bold text-dark">{{ $subcategory->title }}</h5>
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('admin.polls.index', $subcategory->id) }}"
                                        class="btn btn-outline-primary rounded-pill px-4 py-2">Create Polls</a>
                                    <button class="btn btn-outline-warning rounded-pill px-4 py-2 edit-btn"
                                        data-id="{{ $subcategory->id }}" data-title="{{ $subcategory->title }}"
                                        data-thumbnail="{{ asset('storage/' . $subcategory->thumbnail) }}"
                                        data-bs-toggle="modal" data-bs-target="#editSubcategoryModal">
                                        Edit
                                    </button>
                                    <button class="btn btn-outline-danger rounded-pill px-4 py-2 delete-btn"
                                        data-id="{{ $subcategory->id }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteSubcategoryModal">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Create Subcategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Subcategory Modal -->
    <div class="modal fade" id="editSubcategoryModal" tabindex="-1" aria-labelledby="editSubcategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubcategoryModalLabel">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Laravel method spoofing for PUT -->

                        <input type="hidden" id="editSubcategoryId" name="subcategory_id">

                        <!-- Subcategory Title -->
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>

                        <!-- Thumbnail Preview (Optional) -->
                        <div class="mb-3">
                            <label class="form-label">Current Thumbnail</label>
                            <img id="editThumbnailPreview" src="" class="img-thumbnail"
                                style="display: none; max-width: 100px;">
                        </div>

                        <!-- Upload New Thumbnail -->
                        <div class="mb-3">
                            <label for="editThumbnail" class="form-label">Upload New Thumbnail</label>
                            <input type="file" class="form-control" id="editThumbnail" name="thumbnail">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="deleteSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this subcategory?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <style>
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            border: none;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #0056b3, #003580);
        }

        .btn-sm {
            font-size: 0.9rem;
            padding: 0.6rem 1.5rem;
        }

        .rounded-pill {
            border-radius: 50px !important;
        }
    </style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Handle Edit Button Click
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                const subcategoryId = this.getAttribute("data-id");
                const subcategoryTitle = this.getAttribute("data-title");
                const subcategoryThumbnail = this.getAttribute("data-thumbnail");

                // Fill form fields
                document.getElementById("editTitle").value = subcategoryTitle;
                document.getElementById("editSubcategoryId").value = subcategoryId;

                // Show the current thumbnail if available
                if (subcategoryThumbnail) {
                    document.getElementById("editThumbnailPreview").src = subcategoryThumbnail;
                    document.getElementById("editThumbnailPreview").style.display = "block";
                } else {
                    document.getElementById("editThumbnailPreview").style.display = "none";
                }

                // Set the correct form action dynamically
                const editForm = document.getElementById("editForm");
                editForm.action = `/admin/subcategories/${subcategoryId}`;
            });
        });

        // Ensure modal stays open if validation errors occur
        if (document.querySelector("#editSubcategoryModal .alert-danger")) {
            var editSubcategoryModal = new bootstrap.Modal(document.getElementById('editSubcategoryModal'));
            editSubcategoryModal.show();
        }

        // Handle Delete Button Click
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                const subcategoryId = this.getAttribute("data-id");
                const deleteForm = document.getElementById("deleteForm");

                // Update form action dynamically
                deleteForm.action = `/admin/subcategories/${subcategoryId}`;
            });
        });

    });
</script>




@endsection
