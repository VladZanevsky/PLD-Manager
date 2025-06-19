@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" id="select-ispl">
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

            <canvas id="frequencyChart" style="display: none;"></canvas>
            <canvas id="lutChart" style="display: none;"></canvas>
            <canvas id="powerChart" style="display: none;"></canvas>
            <canvas id="ioChart" style="display: none;"></canvas>
            <canvas id="costChart" style="display: none;"></canvas>

            <div class="d-flex justify-content-center align-items-center">
                <a href="#" onclick="history.back(); return false;" class="btn btn-secondary p-2 m-3">Вернуться к результатам</a>
                <a href="#" onclick="event.preventDefault(); chart.resetZoom();" class="btn btn-info p-2 m-3">Сбросить масштаб</a>
                @auth
                    <form action="{{ route('export.pdf') }}" method="POST" id="export-pdf-form">
                        @csrf
                        <input type="hidden" name="chart_images[frequency]" id="frequency_image">
                        <input type="hidden" name="chart_images[lut]" id="lut_image">
                        <input type="hidden" name="chart_images[power]" id="power_image">
                        <input type="hidden" name="chart_images[io]" id="io_image">
                        <input type="hidden" name="chart_images[cost]" id="cost_image">
                        <button type="submit" class="btn btn-primary p-2 m-3">Экспорт в PDF</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary p-2 m-3">Войдите, чтобы экспортировать в PDF</a>
                @endauth
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
                    labels: ['Частота', 'LUT', 'Энергопотребление', 'I/O', 'Стоимость'],
                    datasets: [
                            @foreach($components as $component)
                        {
                            label: '{{ $component->model }}',
                            data: [{{ $component->frequency }}, {{ $component->lut_count }}, {{ $component->power }}, {{ $component->io_count }}, {{ $component->cost }}],
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
            const components = @json($components);
            const models = components.map(c => c.model);

            // Функция для создания графика для PDF
            function createPdfChart(canvasId, label, data, maxValue) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [label],
                        datasets: components.map((c, i) => ({
                            label: c.model,
                            data: [data[i]],
                            backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.5)`
                        }))
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: maxValue * 1.1 // Увеличиваем масштаб на 10%
                            }
                        }
                    }
                });
            }

            const frequencyChart = createPdfChart('frequencyChart', 'Частота (МГц)', components.map(c => c.frequency), Math.max(...components.map(c => c.frequency)));
            const lutChart = createPdfChart('lutChart', 'LUT', components.map(c => c.lut_count), Math.max(...components.map(c => c.lut_count)));
            const powerChart = createPdfChart('powerChart', 'Энергопотребление (Вт)', components.map(c => c.power), Math.max(...components.map(c => c.power)));
            const ioChart = createPdfChart('ioChart', 'I/O', components.map(c => c.io_count), Math.max(...components.map(c => c.io_count)));
            const costChart = createPdfChart('costChart', 'Стоимость', components.map(c => c.cost), Math.max(...components.map(c => c.cost)));

            document.getElementById('export-pdf-form').addEventListener('submit', function(e) {
                document.getElementById('frequency_image').value = frequencyChart.toBase64Image();
                document.getElementById('lut_image').value = lutChart.toBase64Image();
                document.getElementById('power_image').value = powerChart.toBase64Image();
                document.getElementById('io_image').value = ioChart.toBase64Image();
                document.getElementById('cost_image').value = costChart.toBase64Image();
            });
        </script>
    @endsection
@endsection
