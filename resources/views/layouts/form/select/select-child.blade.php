@php
    $counter = $counter ?? 1;
@endphp

@foreach($items as $v)
    @php
        $pk = isset($key_value) ? $v->$key_value : $v->id;
    @endphp

    @if(isset($except) && $except == $pk)
        @continue
    @endif

    <option
        value="{{ $pk }}"

        @selected(old($name, $value ?? null) == $pk)
    >
        {{ str_repeat('-', $counter).' '.$v }}
    </option>
    @if(count($v->$children))
        @include('admin.layouts.form.select.select-child', [
            'items' => $v->$children,
            'counter' => $counter + 1,
            'except' => $except ?? null,
        ])
    @endif
@endforeach
