@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" id="select-ispl" style="min-height: 100vh;">
        <div class="p-4 col-md-5">
            <h1 class="text-center p-3">Подбор ИСПЛ</h1>
            <form action="{{ route('fpga.select') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="frequency">Минимальная частота (МГц)</label>
                    <input type="number" name="frequency" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label for="lut_count">Минимальная логическая емкость (LUT)</label>
                    <input type="number" name="lut_count" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label for="power">Максимальное энергопотребление (Вт)</label>
                    <input type="number" name="power" class="form-control" step="0.1" required min="0">
                </div>
                <div class="form-group">
                    <label for="io_count">Минимальное количество I/O</label>
                    <input type="number" name="io_count" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label for="priority">Приоритет</label>
                    <select name="priority" class="form-control" required>
                        <option value="frequency">Частота</option>
                        <option value="lut_count">Логическая емкость</option>
                        <option value="power">Энергопотребление</option>
                        <option value="cost">Стоимость</option>
                        <option value="balanced">Сбалансировано</option>
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="prefer_domestic" class="form-check-input">
                    <label class="form-check-label">Предпочтение отечественным ИСПЛ</label>
                </div>
                <div class="d-flex justify-content-center align-items-center p-3">
                    <button type="submit" class="btn btn-primary m-3 p-2">Подобрать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
