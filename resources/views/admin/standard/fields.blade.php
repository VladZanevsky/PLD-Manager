@include('layouts.form.text', [
           'title' => 'Название стандарта*',
           'name' => 'name',
           'placeholder' => "Введите навзвание стандарта",
           'value' => $standard->name ?? null,
       ])




