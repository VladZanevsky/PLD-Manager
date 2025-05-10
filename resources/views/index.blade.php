@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" id="select-ispl" style="min-height: 100vh;">
        <div class="p-4 col-md-6">
            <h1 class="text-center p-3">Подбор ИСПЛ</h1>
            <form action="{{ route('fpga.select') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="pl-3" for="frequency">Минимальная частота (МГц)</label>
                    <input type="number" name="frequency" placeholder="Введите минимальную частоту" value="{{ old('frequency') }}" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label class="pl-3" for="lut_count">Минимальная логическая емкость (LUT)</label>
                    <input type="number" name="lut_count" placeholder="Введите минимальную логическую емкость" value="{{ old('lut_count') }}" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label class="pl-3" for="power">Максимальное энергопотребление (Вт)</label>
                    <input type="number" name="power" placeholder="Введите максимальное энергопотребление" value="{{ old('power') }}" class="form-control" step="0.1" min="0">
                </div>
                <div class="form-group">
                    <label class="pl-3" for="io_count">Минимальное количество I/O</label>
                    <input type="number" name="io_count" placeholder="Введите минимальное количество входов/выходов" value="{{ old('io_count') }}" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label class="pl-3" for="standard_ids[]">Стандарты FPGA</label>
                    <select name="standard_ids[]" id="standard_ids" data-dropdown-css-class="select2-danger" data-placeholder="Выберите поддерживаемые стандарты" style="width: 100%;" class="form-control select2 select2-danger select2-hidden-accessible" multiple>
                        @foreach (\App\Models\Standard::all()->sortBy('name') as $standard)
                            <option value="{{ $standard->id }}" {{ in_array($standard->id, old('standard_ids', [])) ? 'selected' : '' }}>
                                {{ $standard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="pl-3" for="priority">Приоритет*</label>
                    <select name="priority" class="form-control" required>
                        <option value="frequency" {{ old('priority') == 'frequency' ? 'selected' : '' }}>Частота</option>
                        <option value="lut_count" {{ old('priority') == 'lut_count' ? 'selected' : '' }}>Логическая емкость</option>
                        <option value="power" {{ old('priority') == 'power' ? 'selected' : '' }}>Энергопотребление</option>
                        <option value="io_count" {{ old('priority') == 'io_count' ? 'selected' : '' }}>Количество входов/выходов</option>
                        <option value="cost" {{ old('priority') == 'cost' ? 'selected' : '' }}>Стоимость</option>
                        <option value="balanced" {{ old('priority') == 'balanced' ? 'selected' : '' }}>Сбалансировано</option>
                    </select>
                </div>
                <div class="form-check">
                    <input id="prefer_domestic" type="checkbox" name="prefer_domestic" class="form-check-input" value="1" {{ old('prefer_domestic') ? 'checked' : '' }}>
                    <label for="prefer_domestic" class="pl-3 form-check-label">Предпочтение отечественным ИСПЛ</label>
                </div>

{{--                <div class="mb-3">--}}
{{--                    <a href="#" id="toggle-advanced-settings">Расширенные настройки</a>--}}
{{--                </div>--}}
                <div class="d-flex justify-content-center align-items-center p-3">
                    <button type="submit" class="btn btn-primary m-3 p-2">Подобрать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
