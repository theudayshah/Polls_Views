@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Manage Polls</h1>
        <div class="d-flex justify-content-center gap-3 mt-3">
            <button class="btn btn-gradient btn-lg rounded-pill" data-bs-toggle="modal" data-bs-target="#addPollModal">
                <i class="fas fa-plus-circle"></i> Create Poll
            </button>
            <a class="btn btn-outline-secondary btn-lg rounded-pill px-4 py-2" href="{{ route('admin.home') }}">
                <i class="fas fa-home"></i> Go to Dashboard
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center rounded-pill fw-bold">
            {{ session('success') }}
        </div>
    @endif

    @if ($polls->isEmpty())
        <p class="text-center text-muted">No polls available.</p>
    @else
        <div class="row g-4">
            @foreach ($polls as $poll)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 hover-scale">
                        <div class="card-body text-center">
                            <h5 class="fw-bold text-dark">{{ $poll->question }}</h5>
                            <hr class="mb-3">
                            <ul class="list-group list-group-flush mb-3">
                                @foreach ($poll->options as $option)
                                    <li class="list-group-item">{{ $option->option_text }}</li>
                                @endforeach
                            </ul>
                            
                            <!-- Button Container - Single Row -->
                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
                                <!-- Toggle Activation -->
                                <form action="{{ route('admin.polls.toggle', $poll->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $poll->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        <i class="fas fa-toggle-on"></i> {{ $poll->is_active ? 'Active' : 'Activate' }}
                                    </button>
                                </form>

                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-warning editPollBtn" data-bs-toggle="modal"
                                    data-bs-target="#editPollModal" data-id="{{ $poll->id }}"
                                    data-question="{{ $poll->question }}"
                                    data-options="{{ json_encode($poll->options) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.polls.destroy', $poll->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this poll?');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>

                                <!-- View Results -->
                                <a href="{{ route('admin.polls.results', $poll->id) }}"
                                    class="btn btn-info btn-sm rounded-pill px-3">
                                    <i class="fas fa-chart-bar"></i> View Results
                                </a>
                            </div> 
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>



    <!-- Create Poll Modal -->
    <div class="modal fade" id="addPollModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Create Poll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.polls.store', $subcategoryId) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required>
                        </div>
                        <div id="optionsContainer">
                            <div class="input-group mb-2">
                                <input type="text" name="options[]" class="form-control" required>
                                <button type="button" class="btn btn-danger removeOptionBtn">X</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="addOptionBtn">+ Add Option</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Poll Modal -->
    <div class="modal fade" id="editPollModal" tabindex="-1" aria-labelledby="editPollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Poll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="editPollForm" method="POST">
                        @csrf
                        <input type="hidden" id="editPollId" name="poll_id">
                        <div class="mb-3">
                            <label class="form-label">Poll Question</label>
                            <input type="text" class="form-control" id="editQuestion" name="question" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Poll Options</label>
                            <div id="editOptionsContainer"></div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="addEditOption">
                                Add Option
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePollModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this poll?</p>
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4"
                        id="confirmDeletePollBtn">Delete</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("addOptionBtn").addEventListener("click", function() {
                let container = document.getElementById("optionsContainer");
                let newOption = document.createElement("div");
                newOption.classList.add("input-group", "mb-2");
                newOption.innerHTML = `<input type="text" class="form-control" name="options[]" required>
                           <button type="button" class="btn btn-danger removeOptionBtn">X</button>`;
                container.appendChild(newOption);
            });

            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeOptionBtn")) {
                    e.target.closest(".input-group").remove();
                }
            });
        });

        function togglePoll(pollId) {
            fetch(`/admin/polls/${pollId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(() => location.reload());
        }


        document.addEventListener("DOMContentLoaded", function() {
            const editPollBtns = document.querySelectorAll(".editPollBtn");

            editPollBtns.forEach(button => {
                button.addEventListener("click", function() {
                    const pollId = this.getAttribute("data-id");
                    const question = this.getAttribute("data-question");
                    let options = this.getAttribute("data-options");

                    try {
                        options = options ? JSON.parse(options) : [];
                    } catch (e) {
                        options = [];
                    }

                    document.getElementById("editPollId").value = pollId;
                    document.getElementById("editQuestion").value = question;

                    const container = document.getElementById("editOptionsContainer");
                    container.innerHTML = "";

                    options.forEach(option => {
                        addOptionInput(container, option.option_text);
                    });

                    document.getElementById("editPollForm").action =
                        `/admin/polls/${pollId}/update`;

                    const modalElement = document.getElementById("editPollModal");
                    if (modalElement) {
                        new bootstrap.Modal(modalElement).show();
                    }
                });
            });

            function addOptionInput(container, value = "") {
                let div = document.createElement("div");
                div.classList.add("input-group", "mb-2");

                let input = document.createElement("input");
                input.type = "text";
                input.name = "options[]";
                input.value = value;
                input.classList.add("form-control");

                input.addEventListener("input", validateUniqueOptions);

                let removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.classList.add("btn", "btn-danger", "remove-option");
                removeBtn.innerHTML = "X";
                removeBtn.addEventListener("click", function() {
                    div.remove();
                    validateUniqueOptions();
                });

                div.appendChild(input);
                div.appendChild(removeBtn);
                container.appendChild(div);

                validateUniqueOptions();
            }

            document.getElementById("addEditOption").addEventListener("click", function() {
                const container = document.getElementById("editOptionsContainer");
                addOptionInput(container);
            });

            function validateUniqueOptions() {
                let optionInputs = document.querySelectorAll("#editOptionsContainer input[name='options[]']");
                let values = new Set();
                let hasDuplicates = false;

                optionInputs.forEach(input => {
                    let value = input.value.trim();

                    if (values.has(value) && value !== "") {
                        hasDuplicates = true;
                        input.classList.add("is-invalid");
                    } else {
                        values.add(value);
                        input.classList.remove("is-invalid");
                    }
                });

                document.querySelector("#editPollForm button[type='submit']").disabled = hasDuplicates;
            }
        });



        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".deletePollBtn").forEach(button => {
                button.addEventListener("click", function() {
                    deletePollId = this.getAttribute("data-id");
                });
            });

            document.getElementById("confirmDeletePollBtn").addEventListener("click", function() {
                if (deletePollId) {
                    fetch(`/admin/polls/${deletePollId}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(() => location.reload());
                }
            });
        });
    </script>
@endsection
