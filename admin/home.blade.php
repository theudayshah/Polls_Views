@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="fw-bold text-primary">Admin Dashboard</h1>
            <button type="button" class="btn btn-gradient btn-sm px-3 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fas fa-plus"></i> Create Category
            </button>
        </div>

        <!-- Category -->
        <div class="row g-4">
            @foreach ($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <div class="card glass-card border-0 shadow-lg rounded-4 hover-scale">
                        @if ($category->thumbnail)
                            <img src="{{ asset('storage/' . $category->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $category->title }}" height="220px" width="100%" style="object-fit: cover;">
                        @endif
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold text-dark mb-3">{{ $category->title }}</h5>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('subcategories.index', $category->id) }}" class="btn btn-outline-secondary btn-sm me-2 rounded-pill">Subcategories</a>
                                <button class="btn btn-warning btn-sm me-2 rounded-pill edit-category"
                                    data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                    data-id="{{ $category->id }}" data-title="{{ $category->title }}" data-thumbnail="{{ $category->thumbnail }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill delete-category"
                                    data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                                    data-id="{{ $category->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white rounded-top">
                    <h5 class="modal-title">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control mb-3" name="title" required>
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" name="thumbnail">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-warning text-white rounded-top">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control mb-3" id="editTitle" name="title" required>
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" id="editThumbnail" name="thumbnail">
                        <img id="currentThumbnail" class="img-thumbnail mt-2" style="max-width: 100px; display: none;">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-danger text-white rounded-top">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".edit-category").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.dataset.id;
                    let title = this.dataset.title;
                    let thumbnail = this.dataset.thumbnail;

                    document.getElementById("editTitle").value = title;
                    let imgTag = document.getElementById("currentThumbnail");
                    if (thumbnail) {
                        imgTag.src = "{{ asset('storage/') }}/" + thumbnail;
                        imgTag.style.display = "block";
                    } else {
                        imgTag.style.display = "none";
                    }

                    document.getElementById("editCategoryForm").action = "{{ route('categories.update', '') }}/" + id;
                });
            });

            document.querySelectorAll(".delete-category").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.dataset.id;
                    document.getElementById("deleteCategoryForm").action = "{{ route('categories.destroy', '') }}/" + id;
                });
            });
        });
    </script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.1);
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
@endsection
