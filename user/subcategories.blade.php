@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">Subcategories of {{ $category->title }}</h1>
            <a class="btn btn-outline-secondary rounded-pill mt-3 px-4 py-2" href="{{ route('user.home') }}">
                Go Back
            </a>
        </div>

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
                                <a href="{{ route('user.polls.index', $subcategory->id) }}" class="btn btn-outline-primary rounded-pill mt-3 px-4 py-2">
                                    View Polls
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
