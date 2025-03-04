@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-primary">Available Polls</h1>
        <a href="{{ route('user.home') }}" class="btn btn-outline-secondary rounded-pill mt-3 px-4 py-2">
            Back to Dashboard
        </a>
    </div>

    <!-- Display Error Message -->
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <!-- Display Poll Section -->
    @if($polls->isEmpty())
        <div class="alert alert-warning text-center">
            There are no active polls currently.
        </div>
    @else
        <div class="row g-4">
            @foreach($polls as $poll)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg overflow-hidden rounded-4 hover-scale">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold text-dark">{{ $poll->question }}</h5>
                            
                            <form action="{{ route('user.polls.vote', $poll->id) }}" method="POST">
                                @csrf
                                <div class="mt-3 text-start d-flex flex-column gap-2">
                                    @foreach($poll->options as $option)
                                        <button type="button" 
                                                class="btn btn-outline-primary option-btn" 
                                                data-option-id="{{ $option->id }}">
                                            {{ $option->option_text }}
                                        </button>
                                    @endforeach
                                </div>

                                <input type="hidden" name="option_id" id="selectedOption" required>

                                <div class="mt-4 d-flex justify-content-center gap-3">
                                    <button type="submit" class="btn btn-gradient btn-sm rounded-pill px-4">
                                        Vote
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Card Hover Effect */
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Option Buttons */
    .option-btn {
        width: 100%;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 6px;
        transition: 0.3s ease;
    }
    .option-btn:hover {
        background: #007bff;
        color: white;
    }
    .option-btn.active {
        background: #0056b3;
        color: white;
    }

    /* Submit & Results Buttons */
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
        let optionButtons = document.querySelectorAll(".option-btn");
        let selectedOptionInput = document.getElementById("selectedOption");

        optionButtons.forEach(button => {
            button.addEventListener("click", function () {
                optionButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");
                selectedOptionInput.value = this.getAttribute("data-option-id");
            });
        });
    });
</script>
@endsection