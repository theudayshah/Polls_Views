@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.polls.index', $poll->subcategory_id) }}" class="btn btn-outline-dark btn shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.polls.report', $poll->id) }}" class="btn btn-success btn shadow-sm rounded-pill px-4 ms-2">
                <i class="bi bi-file-earmark-bar-graph"></i> Get Report
            </a>
        </div>
    </div>

    <!-- Poll Question -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-dark">Poll Results</h2>
        {{-- <h4 class="text-primary">{{ $poll->question }}</h4> --}}
    </div>

    <div class="row g-4 align-items-stretch">
        <!-- Poll Results List -->
        <div class="col-md-5">
            <div class="card shadow-lg p-4 rounded-4 border-0 bg-light">
                <h5 class="text-center text-secondary mb-3">Votes Breakdown</h5>
                <ul class="list-group list-group-flush">
                    @foreach($results as $option)
                        <li class="list-group-item d-flex justify-content-between align-items-center rounded-3 border-0 mb-2 p-3 shadow-sm bg-white">
                            <span class="fw-semibold text-dark">{{ $option->option_text }}</span>
                            <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">{{ $option->votes_count }} votes</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Poll Chart -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4 rounded-4 border-0 bg-white h-100 d-flex flex-column justify-content-center"> <!-- Same height -->
                <div class="text-center mb-3">
                    <label for="chartType" class="form-label fw-bold text-dark">Select Chart Type:</label>
                    <select id="chartType" class="form-select w-auto d-inline-block shadow-sm border-0 bg-light rounded-pill px-4 py-2">
                        <option value="line">Line Chart</option>
                        <option value="bar">Bar Chart</option>
                        <option value="pie">Pie Chart</option>
                    </select>
                </div>
                <div class="chart-container flex-grow-1 d-flex align-items-center justify-content-center" style="position: relative; width: 100%; height: 100%;">
                    <canvas id="pollChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('pollChart').getContext('2d');
        let currentChart;

        const pollData = {
            labels: @json($results->pluck('option_text')),
            datasets: [{
                label: 'Votes',
                data: @json($results->pluck('votes_count')),
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2'],
                borderColor: ['#0056b3', '#1e7e34', '#d39e00', '#b02a37', '#4b0082'],
                borderWidth: 2,
                hoverBackgroundColor: ['#0056b3', '#1e7e34', '#d39e00', '#b02a37', '#4b0082']
            }]
        };

        function renderChart(type) {
            if (currentChart) {
                currentChart.destroy();
            }
            currentChart = new Chart(ctx, {
                type: type,
                data: pollData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true }
                    }
                }
            });
        }

        document.getElementById('chartType').addEventListener('change', function () {
            renderChart(this.value);
        });

        renderChart('line'); // Default chart type
    });
</script>
@endsection
