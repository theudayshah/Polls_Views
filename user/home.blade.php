@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">Explore Categories</h1>
            <p class="text-muted">Browse through various categories and find what interests you</p>
        </div>

        <!-- Display Categories -->

        <div class="row g-4">
            @foreach ($categories as $category)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg overflow-hidden rounded-4 hover-scale">
                        @if ($category->thumbnail)
                            <span class="d-block">
                                <img src="{{ asset('storage/' . $category->thumbnail) }}" class="card-img-top"
                                    alt="{{ $category->title }}" style="height: 220px; object-fit: cover;">
                            </span>
                        @endif
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold text-dark">{{ $category->title }}</h5>
                            <a href="{{ route('user.subcategories.index', ['category' => $category->id]) }}"
                                class="btn btn-outline-primary rounded-pill mt-3 px-4 py-2">
                                Explore Subcategories
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $categories->links('pagination::bootstrap-5') }}
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
    </style>
@endsection
