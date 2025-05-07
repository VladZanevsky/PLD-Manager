<div class="row">
    <div class="col-6">
        @include('layouts.form.select', [
                    'title' => 'Производитель*',
                    'name' => 'manufacturer_id',
                    'items' => $manufacturers,
                    'value' => $fpga_component->manufacturer_id ?? null,
                    'pre_text' => 'Выбрать производителя',
                    'print_attribute' => 'name',
                ])

    </div>
    <div class="col-6">
        @include('layouts.form.text', [
                   'title' => 'Модель*',
                   'name' => 'model',
                   'placeholder' => "Введите модель",
                   'value' => $fpga_component->model ?? null,
               ])
    </div>
</div>
<div class="row">
    <div class="col-6">
        @include('layouts.form.number', [
                   'title' => 'Максималльная частота (МГц)*',
                   'name' => 'frequency',
                   'placeholder' => "Введите максимальную частоту",
                   'min' => 0,
                   'value' => $fpga_component->frequency ?? null,
               ])
    </div>
    <div class="col-6">
        @include('layouts.form.number', [
                   'title' => 'Логическая емкость*',
                   'name' => 'lut_count',
                   'placeholder' => "Введите логическую емкость (LUT)",
                   'min' => 0,
                   'value' => $fpga_component->lut_count ?? null,
               ])
    </div>
</div>
<div class="row">
    <div class="col-6">
        @include('layouts.form.number', [
                   'title' => 'Энергопотребление (Вт)*',
                   'name' => 'power',
                   'placeholder' => "Введите энергопотребление",
                   'min' => 0,
                   'step' => 0.1,
                   'value' => $fpga_component->power ?? null,
               ])
    </div>
    <div class="col-6">
        @include('layouts.form.number', [
                   'title' => 'Количество входов/выходов*',
                   'name' => 'io_count',
                   'placeholder' => "Введите количество входов/выходов",
                   'min' => 0,
                   'value' => $fpga_component->io_count ?? null,
               ])
    </div>
</div>
<div class="row">
    <div class="col-6">
        @include('layouts.form.number', [
                   'title' => 'Цена*',
                   'name' => 'cost',
                   'placeholder' => "Введите цену",
                   'min' => 0,
                   'step' => 0.01,
                   'value' => $fpga_component->cost ?? null,
               ])
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="availability">Доступность*</label>
            <select class="form-control select2 select2-danger select2-hidden-accessible @error('availability') is-invalid @enderror"
                    name="availability" id="availability" data-dropdown-css-class="select2-danger" style="width: 100%;">
                <option value="">Выбрать наличие компонента</option>
                @foreach(['В наличии', 'Под заказ'] as $availability)
                    <option value="{{ $availability }}" @selected(old('availability', $fpga_component->availability ?? null) === $availability)>
                        {{ $availability }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@include('layouts.form.select', [
        'title' => 'Стандарты*',
        'name' => 'standard_id[]',
        'items' => $standards, // Коллекция всех стандартов, например, Standard::all()
        'multiple' => true,
        'values' => isset($fpga_component) ? old('standard_id', $fpga_component->standards->pluck('id')->toArray()) : null,
        'pre_text' => 'Выбрать поддерживаемые стандарты',
        'print_attribute' => 'name',
    ])


{{--<div class="row">--}}
{{--    <div class="col-6">--}}
{{--        @include('layouts.form.select', [--}}
{{--            'title' => 'Категория*',--}}
{{--            'name' => 'animal_id',--}}
{{--            'items' => $animals,--}}
{{--            'value' => $animal_pet->animal_id ?? null,--}}
{{--            'pre_text' => 'Выбрать категорию',--}}
{{--            'print_attribute' => 'name',--}}
{{--        ])--}}
{{--    </div>--}}

{{--    <div class="col-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="role">Пол*</label>--}}
{{--            <select class="form-control select2 select2-danger select2-hidden-accessible @error('sex') is-invalid @enderror"--}}
{{--                    name="sex" id="sex" data-dropdown-css-class="select2-danger" style="width: 100%;">--}}
{{--                <option value="">Выбрать пол</option>--}}
{{--                @foreach(Sex::cases() as $sex)--}}
{{--                    <option value="{{ $sex->value }}" @selected(old('sex', $animal_pet->sex ?? null) === $sex)>--}}
{{--                        {{ $sex->getTitle() }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--@include('layouts.form.textarea',[--}}
{{--    'title' => 'Описание*',--}}
{{--    'name' => 'description',--}}
{{--    'placeholder' => 'Введите описание животного',--}}
{{--    'value' => $animal_pet->description ?? null,--}}
{{--])--}}

{{--<div class="row">--}}
{{--    <div class="col-6">--}}
{{--        @include('layouts.form.date', [--}}
{{--            'title' => 'Дата рождения*',--}}
{{--            'name' => 'birth_date',--}}
{{--            'value' => isset($animal_pet) ? $animal_pet->birth_date->format('Y-m-d') : null,--}}
{{--        ])--}}
{{--    </div>--}}

{{--    <div class="col-6">--}}
{{--        @include('layouts.form.select', [--}}
{{--            'title' => 'Пользователь*',--}}
{{--            'name' => 'user_id',--}}
{{--            'items' => $users,--}}
{{--            'value' => $animal_pet->user_id ?? null,--}}
{{--            'pre_text' => 'Выбрать пользователя',--}}
{{--        ])--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-6">--}}
{{--        @include('layouts.form.filepond-file', [--}}
{{--            'title' => 'Видео*',--}}
{{--            'multiple' => true,--}}
{{--            'name' => 'videos[]',--}}
{{--            'data_files' => $videosFiles ?? null,--}}
{{--            'hidden' => 'video-paths'--}}
{{--        ])--}}
{{--    </div>--}}
{{--    <div class="col-6">--}}
{{--        @include('layouts.form.filepond-file', [--}}
{{--            'title' => 'Фото*',--}}
{{--            'multiple' => true,--}}
{{--            'name' => 'photos[]',--}}
{{--            'data_files' => $photosFiles ?? null,--}}
{{--            'hidden' => 'photo-paths'--}}
{{--        ])--}}
{{--    </div>--}}
{{--</div>--}}


{{--@include('layouts.form.textarea',[--}}
{{--    'title' => 'Характер*',--}}
{{--    'name' => 'character',--}}
{{--    'placeholder' => 'Опишите характер животного',--}}
{{--    'value' => $animal_pet->character ?? null,--}}
{{--])--}}

{{--@include('layouts.form.text', [--}}
{{--           'title' => 'Тип шерсти*',--}}
{{--           'name' => 'wool_type',--}}
{{--           'placeholder' => "Введите тип шерсти",--}}
{{--           'value' => $animal_pet->wool_type ?? null,--}}
{{--       ])--}}

{{--<div class="row">--}}
{{--    <div class="col-4">--}}
{{--        @include('layouts.form.switch', [--}}
{{--           'title' => 'Кастрирован',--}}
{{--           'name' => 'is_sterilized',--}}
{{--           'value' => $animal_pet->is_sterilized ?? null,--}}
{{--       ])--}}
{{--    </div>--}}
{{--    <div class="col-4">--}}
{{--        @include('layouts.form.switch', [--}}
{{--           'title' => 'Вакцинирован',--}}
{{--           'name' => 'has_vaccination',--}}
{{--           'value' => $animal_pet->has_vaccination ?? null,--}}
{{--       ])--}}
{{--    </div>--}}
{{--    <div class="col-4">--}}
{{--        @include('layouts.form.switch', [--}}
{{--           'title' => 'Подтвержден',--}}
{{--           'name' => 'is_confirmed',--}}
{{--           'value' => $animal_pet->is_confirmed ?? null,--}}
{{--       ])--}}
{{--    </div>--}}
{{--</div>--}}



