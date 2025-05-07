<div class="row">
    <div class="col-6">
        @include('layouts.form.text', [
           'title' => 'Название*',
           'name' => 'name',
           'placeholder' => "Введите название производителя",
           'value' => $manufacturer->name ?? null,
       ])
    </div>
    <div class="col-6">
        @include('layouts.form.text', [
           'title' => 'Страна*',
           'name' => 'country',
           'placeholder' => "Введите страну",
           'value' => $manufacturer->country ?? null,
       ])
    </div>
</div>
