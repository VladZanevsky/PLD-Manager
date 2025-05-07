<div class="form-group">
    @isset($title)
        <label for="{{ $id ?? $name }}">{{ $title }}</label>
    @endisset

    @php
        $old = str_replace('[', '.', $name); // Replace [ with .
        $old = str_replace(']', '', $old); // Remove ]
    @endphp

    <select class="form-control select2 select2-danger select2-hidden-accessible
            @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id ?? $name }}"
            @isset($multiple)
                multiple
            data-placeholder="{{ $pre_text }}"
            @endisset
            @if(isset($disabled) && $disabled) disabled @endif
            data-dropdown-css-class="select2-danger" style="width: 100%;"
            @isset($on_change)
                onchange="{{ isset($change_fun) ? $change_fun : 'this.form.submit()' }}"
        @endisset>
        @if(!isset($multiple))
            @isset($pre_text)
                <option selected="selected" value="">{{ $pre_text }}</option>
            @endisset
        @endif
        @foreach($items as $v)
            <option
                @php
                    $pk = isset($key_value) ? $v->$key_value : $v->id;
                @endphp
                value="{{ $pk }}"
            @if(isset($multiple))
                @selected(isset($values) && is_array($values) && in_array($pk, $values))
                    @selected(is_array(old($old, [])) && in_array($pk, old($old, [])))
                @else
                @selected(old($old, $value ?? null) == $pk)
                @endif
            >
                @if(isset($print_attribute))
                    {{ $v->$print_attribute }}
                @else
                    {{ $v }}
                @endif
            </option>
        @endforeach
    </select>
</div>
