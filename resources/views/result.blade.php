@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" id="select-ispl">
        <div class="pb-4 pt-4">
            <h1 class="text-center pb-4">Результаты подбора</h1>
            @if($message)
                <div class="alert alert-warning">{{ $message }}</div>
            @else

            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

                <div id="error-message" class="alert alert-danger text-center" style="display: none;">
                    Выберите компоненты для сравнения
                </div>

                <form action="{{ route('fpga.compare') }}" method="POST" id="compare-form">
                    @csrf
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>Выбрать</th>
                            <th>Модель</th>
                            <th>Производитель</th>
                            <th>Частота (МГц)</th>
                            <th>LUT</th>
                            <th>Энергопотребление (Вт)</th>
                            <th>I/O</th>
                            <th>Стоимость</th>
                            <th>Оценка</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($components as $component)
                            @php
                            if (isset($maxScore))
                                {
                                    $relative = $component->score / $maxScore;
                                    if ($component->score == $maxScore) {
                                        $label = 'Лучший вариант';
                                        $badgeClass = 'bg-success';
                                    } elseif ($relative >= 0.75) {
                                        $label = 'Хороший выбор';
                                        $badgeClass = 'bg-warning text-dark';
                                    } else {
                                        $label = 'Средний вариант';
                                        $badgeClass = 'bg-secondary';
                                    }
                                }
                            @endphp
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="{{ $component->id }}"></td>
                                <td>{{ $component->model }}</td>
                                <td>{{ $component->manufacturer->name }}</td>
                                <td>{{ $component->frequency }}</td>
                                <td>{{ $component->lut_count }}</td>
                                <td>{{ $component->power }}</td>
                                <td>{{ $component->io_count }}</td>
                                <td>{{ $component->cost }}</td>
                                <td>{{ number_format($component->score, 3) }}<br>
                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary p-2 m-3">Сравнить выбранные</button>
                        <a href="#" onclick="history.back(); return false;" class="btn btn-secondary p-2 m-3">Вернуться к вводу</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('compare-form').addEventListener('submit', function(e) {
            const selected = document.querySelectorAll('input[name="selected[]"]:checked');
            const content = document.getElementById('select-ispl')
            const errorMessage = document.getElementById('error-message');

            if (selected.length === 0) {
                e.preventDefault();
                errorMessage.style.display = 'block';
                content.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 10000);
            } else {
                errorMessage.style.display = 'none';
            }
        });
    </script>
@endsection
