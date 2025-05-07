@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="pb-4 pt-4">
            <h1 class="text-center pb-4">Сравнение ИСПЛ</h1>
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th>Параметр</th>
                    @foreach($components as $component)
                        <th>{{ $component->model }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr><td>Частота (МГц)</td>@foreach($components as $c)<td>{{ $c->frequency }}</td>@endforeach</tr>
                <tr><td>LUT</td>@foreach($components as $c)<td>{{ $c->lut_count }}</td>@endforeach</tr>
                <tr><td>Энергопотребление (Вт)</td>@foreach($components as $c)<td>{{ $c->power }}</td>@endforeach</tr>
                <tr><td>I/O</td>@foreach($components as $c)<td>{{ $c->io_count }}</td>@endforeach</tr>
                <tr><td>Стоимость</td>@foreach($components as $c)<td>{{ $c->cost }}</td>@endforeach</tr>
                <tr><td>Стандарты</td>@foreach($components as $c)<td>{{ $c->standards->pluck('name')->join(', ') }}</td>@endforeach</tr>
                </tbody>
            </table>
            <canvas id="comparisonChart"></canvas>
            <div class="d-flex justify-content-center align-items-center">
                <a href="#" onclick="history.back(); return false;" class="btn btn-secondary p-2 m-3">Вернуться к результатам</a>
                <a href="#" onclick="event.preventDefault(); chart.resetZoom();" class="btn btn-info p-2 m-3">Сбросить масштаб</a>
                <a href="{{ url('/export-pdf') }}" class="btn btn-primary p-2 m-3">Экспорт в PDF</a>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.2.1/dist/chartjs-plugin-zoom.min.js"></script>
        <script>
            const ctx = document.getElementById('comparisonChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Частота', 'LUT', 'Энергопотребление', 'I/O'],
                    datasets: [
                            @foreach($components as $component)
                        {
                            label: '{{ $component->model }}',
                            data: [{{ $component->frequency }}, {{ $component->lut_count }}, {{ $component->power }}, {{ $component->io_count }}],
                            backgroundColor: 'rgba({{ rand(0,255) }}, {{ rand(0,255) }}, {{ rand(0,255) }}, 0.5)'
                        },
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'y',
                            },
                            zoom: {
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'y',
                            }
                        }
                    }
                }
            });
        </script>
    @endsection
@endsection
