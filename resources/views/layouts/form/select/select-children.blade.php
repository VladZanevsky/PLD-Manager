<div class="form-group">
    @isset($title)
        <label for="{{ $id ?? $name }}">{{ $title }}</label>
    @endisset
    <select class="form-control select2 select2-danger select2-hidden-accessible
            @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id ?? $name }}"
            @isset($disabled) disabled @endisset
            data-dropdown-css-class="select2-danger" style="width: 100%;" @isset($on_change) onchange="this.form.submit()" @endisset >
        @isset($pre_text)
            <option selected="selected" value="">{{ $pre_text }}</option>
        @endisset
        @foreach($items as $v)

            @php
                $pk = isset($key_value) ? $v->$key_value : $v->id;
            @endphp

            @if(isset($except) && $except == $pk)
                @continue
            @endif

            <option

                value="{{ $pk }}"

                @isset($values)
                    @selected(in_array($pk, $values))
                @endisset

                @selected(old($name, $value ?? null) == $pk)
            >
                {{ $v }}
            </option>
            @if(count($v->$children))
                @include('admin.layouts.form.select.select-child', [
                    'items' => $v->$children,
                    'except' => $except ?? null,
                ])
            @endif
        @endforeach
    </select>
</div>
