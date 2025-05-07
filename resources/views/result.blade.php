@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center">
        <div class="pb-4 pt-4">
            <h1 class="text-center pb-4">Результаты подбора</h1>
            @if($message)
                <div class="alert alert-warning">{{ $message }}</div>
            @else
                <form action="{{ route('fpga.compare') }}" method="POST">
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
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="{{ $component->id }}"></td>
                                <td>{{ $component->model }}</td>
                                <td>{{ $component->manufacturer->name }}</td>
                                <td>{{ $component->frequency }}</td>
                                <td>{{ $component->lut_count }}</td>
                                <td>{{ $component->power }}</td>
                                <td>{{ $component->io_count }}</td>
                                <td>{{ $component->cost }}</td>
                                <td>{{ number_format($component->score, 3) }}</td>
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
