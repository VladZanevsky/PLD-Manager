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
            data-dropdown-css-class="select2-danger" style="width: 100%;" @isset($on_change) onchange="this.form.submit()" @endisset >

        @if(!isset($multiple))
            @isset($pre_text)
                <option selected="selected" value="">{{ $pre_text }}</option>
            @endisset
        @endif
        @foreach($items as $item)
            <optgroup label="{{ isset($category_key) ? $item->$category_key : $item }}">
                @php
                    $children = isset($child_key) ? $item->$child_key : $item;
                @endphp
                @foreach($children as $v)
                    <option

                        @php
                            $pk = isset($key_value) ? $v->$key_value : $v->id;
                        @endphp

                        value="{{ $pk }}"

                        @isset($values)
                            @selected(in_array($pk, $values))
                        @endisset

                        @selected(old($old, $value ?? null) == $pk)
                    >
                        {{ $v }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
