@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" id="select-ispl" style="min-height: 100vh;">
        <div class="p-4 col-md-6 position-relative">


            <!-- Форма -->
            <h1 class="text-center p-3">Подбор ИСПЛ</h1>
            <form action="{{ route('fpga.select') }}" method="POST">
                @csrf
                <!-- Блок с ползунками -->
                <div id="advanced-settings" class="advanced-settings text-center" style="display: none;">
                    <h4 class="p-3">Выберите приоритет параметров (вес)</h4>
                    <div class="form-group mb-3">
                        <label class="pl-3" for="weight_frequency">Частота</label>
                        <div class="d-flex align-items-center">
                            <input type="range" name="weight_frequency" id="weight_frequency" class="form-range" min="0" max="100" disabled value="20" oninput="document.getElementById('weight_frequency_value').textContent = this.value">
                            <span id="weight_frequency_value" class="range-value ms-2">20</span> %
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="pl-3" for="weight_lut_count">Логическая емкость</label>
                        <div class="d-flex align-items-center">
                            <input type="range" name="weight_lut_count" id="weight_lut_count" class="form-range" min="0" max="100" disabled value="20" oninput="document.getElementById('weight_lut_count_value').textContent = this.value">
                            <span id="weight_lut_count_value" class="range-value ms-2">20</span> %
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="pl-3" for="weight_power">Энергопотребление</label>
                        <div class="d-flex align-items-center">
                            <input type="range" name="weight_power" id="weight_power" class="form-range" min="0" max="100" disabled value="20" oninput="document.getElementById('weight_power_value').textContent = this.value">
                            <span id="weight_power_value" class="range-value ms-2">20</span> %
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="pl-3" for="weight_cost">Стоимость</label>
                        <div class="d-flex align-items-center">
                            <input type="range" name="weight_cost" id="weight_cost" class="form-range" min="0" max="100" disabled value="20" oninput="document.getElementById('weight_cost_value').textContent = this.value">
                            <span id="weight_cost_value" class="range-value ms-2">20</span> %
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="pl-3" for="weight_io_count">Кол-во входов/выходов</label>
                        <div class="d-flex align-items-center">
                            <input type="range" name="weight_io_count" id="weight_io_count" class="form-range" min="0" max="100" disabled value="20" oninput="document.getElementById('weight_io_count_value').textContent = this.value">
                            <span id="weight_io_count_value" class="range-value ms-2">20</span> %
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="pl-3" for="frequency">Минимальная частота (МГц)</label>
                    <input type="number" name="frequency" placeholder="Введите минимальную частоту" value="{{ old('frequency') }}" class="form-control" min="0">
                </div>
                <div class="form-group mb-3">
                    <label class="pl-3" for="lut_count">Минимальная логическая емкость (LUT)</label>
                    <input type="number" name="lut_count" placeholder="Введите минимальную логическую емкость" value="{{ old('lut_count') }}" class="form-control" min="0">
                </div>
                <div class="form-group mb-3">
                    <label class="pl-3" for="power">Максимальное энергопотребление (Вт)</label>
                    <input type="number" name="power" placeholder="Введите максимальное энергопотребление" value="{{ old('power') }}" class="form-control" step="0.1" min="0">
                </div>
                <div class="form-group mb-3">
                    <label class="pl-3" for="io_count">Минимальное количество I/O</label>
                    <input type="number" name="io_count" placeholder="Введите минимальное количество входов/выходов" value="{{ old('io_count') }}" class="form-control" min="0">
                </div>
                <div class="form-group mb-3">
                    <label class="pl-3" for="standard_ids[]">Стандарты FPGA</label>
                    <select name="standard_ids[]" id="standard_ids" data-dropdown-css-class="select2-danger" data-placeholder="Выберите поддерживаемые стандарты" style="width: 100%;" class="form-control select2 select2-danger select2-hidden-accessible" multiple>
                        @foreach (\App\Models\Standard::all()->sortBy('name') as $standard)
                            <option value="{{ $standard->id }}" {{ in_array($standard->id, old('standard_ids', [])) ? 'selected' : '' }}>
                                {{ $standard->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3" id="priority-group">
                    <label class="pl-3" for="priority">Приоритет*</label>
                    <select name="priority" id="priority" class="form-control">
                        <option value="frequency" {{ old('priority') == 'frequency' ? 'selected' : '' }}>Частота</option>
                        <option value="lut_count" {{ old('priority') == 'lut_count' ? 'selected' : '' }}>Логическая емкость</option>
                        <option value="power" {{ old('priority') == 'power' ? 'selected' : '' }}>Энергопотребление</option>
                        <option value="io_count" {{ old('priority') == 'io_count' ? 'selected' : '' }}>Количество входов/выходов</option>
                        <option value="cost" {{ old('priority') == 'cost' ? 'selected' : '' }}>Стоимость</option>
                        <option value="balanced" {{ old('priority') == 'balanced' ? 'selected' : '' }}>Сбалансировано</option>
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input id="prefer_domestic" type="checkbox" name="prefer_domestic" class="form-check-input" value="1" {{ old('prefer_domestic') ? 'checked' : '' }}>
                    <label for="prefer_domestic" class="pl-3 form-check-label">Предпочтение отечественным ИСПЛ</label>
                </div>
                @auth
                    <div class="mt-2">
                        <a href="#" class="pl-3 mt-6" id="toggle-advanced-settings">Расширенные настройки</a>
                    </div>
                @else
                    <div class="mt-2">
                        <a href="{{ route('login') }}" class="pl-3 mt-6">Расширенные настройки доступны только для зарегистрированных пользователей</a>
                    </div>
                @endauth
                <div class="d-flex justify-content-center align-items-center pb-3">
                    <button type="submit" class="btn btn-primary m-3 p-2">Подобрать</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .advanced-settings {
            position: absolute;
            left: -350px;
            top: 1.2rem;
            width: 300px;
            z-index: 1000;
            padding: 15px;
        }
        input[type="range"] {
            width: 220px;
        }
        .range-value {
            width: 40px;
            text-align: right;
        }
        @media (max-width: 768px) {
            .advanced-settings {
                position: static;
                width: 100%;
                margin-top: 20px;
                box-shadow: none;
                border: none;
            }
        }
    </style>

    <script>
        document.getElementById('toggle-advanced-settings').addEventListener('click', function(e) {
            e.preventDefault();
            const advancedSettings = document.getElementById('advanced-settings');
            const priorityGroup = document.getElementById('priority-group');
            const prioritySelect = document.getElementById('priority');
            const sliders = advancedSettings.querySelectorAll('input[type="range"]');
            const isHidden = advancedSettings.style.display === 'none' || advancedSettings.style.display === '';
            advancedSettings.style.display = isHidden ? 'block' : 'none';
            priorityGroup.style.display = isHidden ? 'none' : 'block';
            prioritySelect.disabled = isHidden;
            sliders.forEach(slider => {
                slider.disabled = !isHidden;
            });
            this.textContent = isHidden ? 'Скрыть расширенные настройки' : 'Расширенные настройки';
        });
    </script>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection
